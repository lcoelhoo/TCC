#include <TinyGPS++.h>
#include <axp20x.h>
#include <LoRa.h>
#include <SPI.h>
#include <Wire.h>
 
/* Definições gerais */
#define ID_MODULO                    1
#define BYTE_SINCRONIA_1            'M'
#define BYTE_SINCRONIA_2            'E'

#define SCK_LORA           5
#define MISO_LORA          19
#define MOSI_LORA          27
#define RESET_PIN_LORA     23
#define SS_PIN_LORA        18

#define LORA_GANHO_MAX     20              /* dBm */
#define HIGH_GAIN_LORA     LORA_GANHO_MAX
#define BAND               915E6           /* 915MHz de frequencia */

/* Definicoes - serial de debug */
#define DEBUG_SERIAL_BAUDRATE    115200

/* Definições - GPS */
/* O módulo GPS da placa está ligado na serial 1 do ESP32 */
#define SERIAL_GPS                  1 
#define BAUDRATE_SERIAL_GPS         9600
#define GPIO_RX_SERIAL_GPS          34
#define GPIO_TX_SERIAL_GPS          12
#define TEMPO_ENTRE_LEITURAS_GPS    1000
#define TEMPO_LEITURA_SERIAL_GPS    500  

typedef struct __attribute__((__packed__))  
{   
   char byte_sincronia_1;
   char byte_sincronia_2;
   int id_modulo;
   double latitude;
   double longitude;
   float velocidade;
   unsigned long diferenca_tempo_posicoes_gps;   
   char checksum;
}TPosicao_GPS_LoRa;

unsigned long timestamp_gps_lora;
TinyGPSPlus gps;
HardwareSerial GPS(SERIAL_GPS);
AXP20X_Class axp;
TPosicao_GPS_LoRa posicao_gps_lora;

bool init_comunicacao_lora(void);
bool init_gps(void);
unsigned long diferenca_tempo(unsigned long t_ref);
char calcula_checksum(void);



bool init_comunicacao_lora(void)
{
    bool status_init = false;
    Serial.println("[LoRa Receiver] Tentando iniciar comunicacao com o radio LoRa...");
    SPI.begin(SCK_LORA, MISO_LORA, MOSI_LORA, SS_PIN_LORA);
    LoRa.setPins(SS_PIN_LORA, RESET_PIN_LORA, 26);
    
    if (!LoRa.begin(BAND)) 
    {
        Serial.println("Comunicacao com o radio LoRa falhou");        
        status_init = false;
    }
    else
    {
        /* Configura o ganho do receptor LoRa para 20dBm, o maior ganho possível (visando maior alcance possível) */ 
        LoRa.setTxPower(HIGH_GAIN_LORA); 
        Serial.println("Comunicacao com o radio LoRa ok");
        status_init = true;
    }

    return status_init;
}





bool init_gps(void)
{
    bool status_init = true;
        Wire.begin(21, 22);
    if (!axp.begin(Wire, AXP192_SLAVE_ADDRESS)) 
    {
        Serial.println("Sucesso ao inicializar comunicação com chip");        
        status_init = true;
    }
    else
    {
        Serial.println("Falha ao inicializar comunicação com chip");
        status_init = false;
    }
    if (status_init == true)
    {
        axp.setPowerOutPut(AXP192_LDO2, AXP202_ON);
        axp.setPowerOutPut(AXP192_LDO3, AXP202_ON);
        axp.setPowerOutPut(AXP192_DCDC1, AXP202_ON);
        axp.setPowerOutPut(AXP192_DCDC2, AXP202_ON);
        axp.setPowerOutPut(AXP192_DCDC3, AXP202_ON);
        axp.setPowerOutPut(AXP192_EXTEN, AXP202_ON);
 
        GPS.begin(BAUDRATE_SERIAL_GPS, 
                  SERIAL_8N1, 
                  GPIO_RX_SERIAL_GPS, 
                  GPIO_TX_SERIAL_GPS);
    }
    return status_init;
}






char calcula_checksum(void)
{
    unsigned char * pt_dados = (unsigned char *)&posicao_gps_lora;
    int tamanho_bytes = sizeof(TPosicao_GPS_LoRa) - 1;
    int i;
    char soma_bytes;
    char checksum_calculado;

    soma_bytes = 0;
    
    for (i=0; i<tamanho_bytes; i++)
    {
        soma_bytes = soma_bytes + *pt_dados;
        pt_dados++;
    }

    checksum_calculado = (~soma_bytes) + 1;
    return checksum_calculado;
}






void setup() 
{    
    /* Inicializa serial de debug */
    Serial.begin(DEBUG_SERIAL_BAUDRATE);

    if (init_gps() == false)
    {
        Serial.println("Impossivel liberar energia para módulo GPS. O ESP32 sera reiniciado em 1 segundo...");
        delay(1000);
        ESP.restart();
    }

    if (init_comunicacao_lora() == false)
    {
        Serial.println("Impossivel se comunicar com chip LoRa. O ESP32 sera reiniciado em 1 segundo...");
        delay(1000);
        ESP.restart();
    }


    /* Inicializa temporização do GPS e envio LoRa */
    timestamp_gps_lora = millis();
}






void loop() 
{
    unsigned long timestamp_leitura_gps;

    timestamp_leitura_gps = millis();
    do
    {
        while (GPS.available())
            gps.encode(GPS.read());
    } while ( diferenca_tempo(timestamp_leitura_gps) < TEMPO_LEITURA_SERIAL_GPS);

    diferenca_tempo_gps_lora = diferenca_tempo(timestamp_gps_lora);    
  
    if (diferenca_tempo_gps_lora >= TEMPO_ENTRE_LEITURAS_GPS)
    {
        posicao_gps_lora.byte_sincronia_1 = BYTE_SINCRONIA_1;
        posicao_gps_lora.byte_sincronia_2 = BYTE_SINCRONIA_2;
        posicao_gps_lora.id_modulo = ID_MODULO;
        posicao_gps_lora.latitude = gps.location.lat();
        posicao_gps_lora.longitude = gps.location.lng();
        posicao_gps_lora.velocidade = gps.speed.kmph();
        posicao_gps_lora.checksum = calcula_checksum();

        LoRa.beginPacket();
        LoRa.write((unsigned char *)&posicao_gps_lora, sizeof(TPosicao_GPS_LoRa));
        LoRa.endPacket(); 
        Serial.println("Posição enviada por LoRa para receptor / gateway");
               
        timestamp_gps_lora = millis();
    }
    
}
