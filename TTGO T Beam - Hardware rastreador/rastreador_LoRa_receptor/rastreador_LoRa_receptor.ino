
#include <LoRa.h>
#include <SPI.h>
#include <Wire.h>
#include <time.h>


/*
#include <WiFi.h>

const char* ssid = "WiFi_SideInfo2.4";
const char* password =  "kakto321";*/



/*Entra CT1 */
const String latct1 = "-25.8208";
const String longct1 = "-53.3645";
/*Sair CT1 */
const String fimct1lat = "-25.8204";
const String fimct1long =  "-53.3648";

/*Entra ET1 */
const String latet1 = "-25.8203";
const String longet1 = "-53.3643";
/*Sair ET1 */
const String fimet1lat = "-25.8209";
const String fimet1long = "-53.3635";

int verificavolta1 = 0;
int volta = 1;
int salvatrajeto = 0;


/* Definições gerais */
#define ID_MODULO_PARA_RECEBER      1
#define BYTE_SINCRONIA_1            'M'
#define BYTE_SINCRONIA_2            'E'

/* Definições - máquina de estado */
#define ESTADO_BYTE_SYNC_1            0x00
#define ESTADO_BYTE_SYNC_2            0x01
#define ESTADO_RECEBE_RESTANTE_DADOS  0x02

#define SCK_LORA           5
#define MISO_LORA          19
#define MOSI_LORA          27
#define RESET_PIN_LORA     23
#define SS_PIN_LORA        18

/* Definicoes de ganho e frequência de operação do rádio LoRa */
#define LORA_GANHO_MAX     20              /* dBm */
#define HIGH_GAIN_LORA     LORA_GANHO_MAX
#define BAND               915E6           /* 915MHz de frequencia */

/* Definicoes - serial de debug */
#define DEBUG_SERIAL_BAUDRATE    115200

/* Estrutura de dados a serem recebidos por LoRa */
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

TPosicao_GPS_LoRa posicao_gps_lora;
char estado_atual = ESTADO_BYTE_SYNC_1;

bool init_comunicacao_lora(void);
unsigned long diferenca_tempo(unsigned long t_ref);
char calcula_checksum(void);
bool maquina_estados(char byte_recebido);
int tamanho_a_receber;
unsigned char * pt_dados_recebidos;


bool init_comunicacao_lora(void)
{
    bool status_init = false;
   /*  iniciar comunicacao com o radio LoRa...");*/
    SPI.begin(SCK_LORA, MISO_LORA, MOSI_LORA, SS_PIN_LORA);
    LoRa.setPins(SS_PIN_LORA, RESET_PIN_LORA, 26);
    
    if (!LoRa.begin(BAND)) 
    {
      /*  Serial.println("Comunicacao com o radio LoRa falhou");  */      
        status_init = false;
    }
    else
    {
        /* Configura o ganho do receptor LoRa para 20dBm */ 
        LoRa.setTxPower(HIGH_GAIN_LORA); 
        status_init = true;
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


bool maquina_estados(char byte_recebido)
{
    bool resultado = false;
    char checksum_calculado;

    switch (estado_atual)
    {
        case ESTADO_BYTE_SYNC_1:
            /*Serial.println("Estado: ESTADO_BYTE_SYNC_1");*/
            
            resultado = false;
            
            if (byte_recebido == BYTE_SINCRONIA_1)
            {
                pt_dados_recebidos = (unsigned char *)&posicao_gps_lora;
                *pt_dados_recebidos = byte_recebido;
                pt_dados_recebidos++;
                estado_atual = ESTADO_BYTE_SYNC_2;
            }
            
            break;

        case ESTADO_BYTE_SYNC_2:

            resultado = false;
            
            if (byte_recebido == BYTE_SINCRONIA_2)
            {
                
                *pt_dados_recebidos = byte_recebido;
                pt_dados_recebidos++;
                tamanho_a_receber = sizeof(TPosicao_GPS_LoRa) - 2;
                estado_atual = ESTADO_RECEBE_RESTANTE_DADOS;
            }
            else
            {
               
                estado_atual = ESTADO_BYTE_SYNC_1;
            }
                
            break;

        case ESTADO_RECEBE_RESTANTE_DADOS:
        
            *pt_dados_recebidos = byte_recebido;
            pt_dados_recebidos++;
            tamanho_a_receber = tamanho_a_receber - 1;

            if (tamanho_a_receber == 0)
            {
                /* Todos os dados recebidos. O checksum será conferido. */   
                checksum_calculado = calcula_checksum();

                if (checksum_calculado == posicao_gps_lora.checksum)
                {
                    /* Checksum ok. Dados válidos. 
                    Serial.println("Dados recebidos e checksum ok.");*/
                    resultado = true;
                }
                else
                {
                    /* Checksum falhou. Dados inválidos. 
                    Serial.println("Dados recebidos e checksum invalido."); */
                    resultado = false;
                }

                /* Reseta máquina de estados */
                estado_atual = ESTADO_BYTE_SYNC_1;              
            }                             
            else
                resultado = false;
            
            break;
    }

    return resultado;
}

void setup() 
{
  
/* Inicializa serial de debug */
    Serial.begin(DEBUG_SERIAL_BAUDRATE);
 /*   
  WiFi.begin(ssid, password); 
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.println("Connecting to WiFi..");
   
  }
 
  Serial.print("Connected to the WiFi network: IP:");
  Serial.println(WiFi.localIP());
*/
    

    /* Inicializa comunicação LoRa */
    if (init_comunicacao_lora() == false)
    {
       /* Serial.println("Impossivel se comunicar com chip LoRa. O ESP32 sera reiniciado em 1 segundo");*/
        delay(1000);
        ESP.restart();
    }
}

void loop() 
{
    int packet_size;
    char byte_lido;
    int id_modulo;
    double latitude;
    double longitude;
    double teste;
    float velocidade;
    unsigned long diferenca_tempo_posicoes_gps;

    packet_size = LoRa.parsePacket();

    if (packet_size > 0) 
    {
        while (LoRa.available())
        {
            byte_lido = (char)LoRa.read();

          /*  Serial.print("Byte recebido:");
            Serial.println(byte_lido);*/
            
            if (maquina_estados(byte_lido) == true)
            {
                /* Dados recebidos já filtrados */
                id_modulo = posicao_gps_lora.id_modulo;
                latitude = posicao_gps_lora.latitude;
                longitude = posicao_gps_lora.longitude;
                velocidade = posicao_gps_lora.velocidade;
                diferenca_tempo_posicoes_gps = posicao_gps_lora.diferenca_tempo_posicoes_gps;
                String latitude1 = String(latitude,4);
                String longitude1 = String(longitude,4); 
 


                /*Inicio CT*/     
                if (latct1 == latitude1 && longct1 == longitude1 && verificavolta1 == 0 ){                  
                  Serial.print("INSERT INTO `cronometragem` (`idcronometragem`, `longitude`, `latitude`, `CodPiloto`, `CTinicial`, `CTfinal`, `ET1inicial`, `ET1final`, `Volta`, `Tempo`) VALUES (NULL, '");
                  Serial.print(latitude,4);
                  Serial.print("', '");
                  Serial.print(longitude,4);
                  Serial.print("', '");
                 /* Serial.print(id_modulo);*/
                 Serial.print("2");
                  Serial.print("', '1', '0', '0', '0', '1', '");
                  Serial.print("horaatual");
                  Serial.println("'); *");
                  contagem();
                  trajeto();
                  delay(5000);                              

                  }

                  /*Inicio CT Volta 2*/ 
                  
                   if (latct1 == latitude1 && longct1 == longitude1 && verificavolta1 == 4 && volta == 2 ){                  
                  Serial.print("INSERT INTO `cronometragem` (`idcronometragem`, `longitude`, `latitude`, `CodPiloto`, `CTinicial`, `CTfinal`, `ET1inicial`, `ET1final`, `Volta`, `Tempo`) VALUES (NULL, '");
                  Serial.print(latitude,4);
                  Serial.print("', '");
                  Serial.print(longitude,4);
                  Serial.print("', '");
                 /* Serial.print(id_modulo);*/
                 Serial.print("2");
                  Serial.print("', '1', '0', '0', '0', '2', '");
                  Serial.print("horaatual");
                  Serial.println("') *");
                  contagem();
                  delay(5000); 

                  }

                   if (fimct1lat == latitude1 && fimct1long == longitude1 && verificavolta1 == 1 ){                  
                  Serial.print("INSERT INTO `cronometragem` (`idcronometragem`, `longitude`, `latitude`, `CodPiloto`, `CTinicial`, `CTfinal`, `ET1inicial`, `ET1final`, `Volta`, `Tempo`) VALUES (NULL, '");
                  Serial.print(latitude1);
                  Serial.print("', '");
                  Serial.print(longitude,4);
                  Serial.print("', '");
                  /*Serial.print(id_modulo);*/
                  Serial.print("', '0', '1', '0', '0', '1', '");
                  Serial.print("horaatual");
                  Serial.println("') *");
                  contagem();
                  delay(5000); 
                  }

                   if (fimct1lat == latitude1 && fimct1long == longitude1 && verificavolta1 == 5 && volta == 2 ){                  
                  Serial.print("INSERT INTO `cronometragem` (`idcronometragem`, `longitude`, `latitude`, `CodPiloto`, `CTinicial`, `CTfinal`, `ET1inicial`, `ET1final`, `Volta`, `Tempo`) VALUES (NULL, '");
                  Serial.print(latitude1);
                  Serial.print("', '");
                  Serial.print(longitude,4);
                  Serial.print("', '");
                 /* Serial.print(id_modulo);*/
                 Serial.print("2");
                  Serial.print("', '0', '1', '0', '0', '2', '");
                  Serial.print("horaatual");
                  Serial.println("') *"); 
                  contagem();
                  delay(5000); 
                                
                  }
                  /*Fim CT*/


                  /*Inicio ET1*/     
                if (latet1 == latitude1 && longet1 == longitude1 && verificavolta1 == 2 ){                  
                  Serial.print("INSERT INTO `cronometragem` (`idcronometragem`, `longitude`, `latitude`, `CodPiloto`, `CTinicial`, `CTfinal`, `ET1inicial`, `ET1final`, `Volta`, `Tempo`) VALUES (NULL, '");
                  Serial.print(latitude,4);
                  Serial.print("', '");
                  Serial.print(longitude,4);
                  Serial.print("', '");
                /*  Serial.print(id_modulo);*/
                Serial.print("2");
                  Serial.print("', '0', '0', '1', '0', '1', '");
                  Serial.print("horaatual");
                  Serial.println("') *");
                  contagem();
                  delay(5000); 
                  }

                  if (latet1 == latitude1 && longet1 == longitude1 && verificavolta1 == 6 && volta == 2){                  
                  Serial.print("INSERT INTO `cronometragem` (`idcronometragem`, `longitude`, `latitude`, `CodPiloto`, `CTinicial`, `CTfinal`, `ET1inicial`, `ET1final`, `Volta`, `Tempo`) VALUES (NULL, '");
                  Serial.print(latitude,4);
                  Serial.print("', '");
                  Serial.print(longitude,4);
                  Serial.print("', '");
                 /* Serial.print(id_modulo);*/
                 Serial.print("2");
                  Serial.print("', '0', '0', '1', '0', '2', '");
                  Serial.print("horaatual");
                  Serial.println("') *");
                  contagem();
                  delay(5000); 
                  }

                   if (fimet1lat == latitude1 && fimet1long == longitude1 && verificavolta1 == 3){                  
                  Serial.print("INSERT INTO `cronometragem` (`idcronometragem`, `longitude`, `latitude`, `CodPiloto`, `CTinicial`, `CTfinal`, `ET1inicial`, `ET1final`, `Volta`, `Tempo`) VALUES (NULL, '");
                  Serial.print(latitude,4);
                  Serial.print("', '");
                  Serial.print(longitude,4);
                  Serial.print("', '");
                  /*Serial.print(id_modulo);*/
                  Serial.print("2");
                  Serial.print("', '0', '0', '0', '1', '1', '");
                  Serial.print("horaatual");
                  Serial.println("') *");  
                  contagem();
                  voltafeita();
                  delay(5000);      
                  }

                   if (fimet1lat == latitude1 && fimet1long == longitude1 && verificavolta1 == 7 && volta == 2){                  
                  Serial.print("INSERT INTO `cronometragem` (`idcronometragem`, `longitude`, `latitude`, `CodPiloto`, `CTinicial`, `CTfinal`, `ET1inicial`, `ET1final`, `Volta`, `Tempo`) VALUES (NULL, '");
                  Serial.print(latitude,4);
                  Serial.print("', '");
                  Serial.print(longitude,4);
                  Serial.print("', '");
                  Serial.print("2");
                 /* Serial.print(id_modulo);*/
                  Serial.print("', '0', '0', '0', '1', '2', '");
                  Serial.print("horaatual");
                  Serial.println("') *");  
                  contagem();
                  fimtrajeto();
                  delay(5000); 
                    
                  }
                  /*Fim ET1

               
             if (salvatrajeto == 1){   */ 
              
                Serial.print("INSERT INTO `localizacao` (`idlocalizacao`, `CodPiloto`, `Latitude`, `Longitude`, `Velocidade`) VALUES (NULL, '");
                Serial.print(id_modulo);
               /*Serial.print("2");*/
                Serial.print("', '");          
                Serial.print(latitude1);
                 Serial.print("', '"); 
                Serial.print(longitude1);
                 Serial.print("', '");   
                Serial.print(velocidade);
                 Serial.println("') *");
                   /*Fim gravar trajeto 
               }*/


             /* Ver Localizacao 
               Serial.print(latitude1);
               Serial.println(longitude1); */ 
        }       
    }
    
}}

void contagem() {
    verificavolta1 = verificavolta1+1;
}
void voltafeita() {
    volta = 2;
}
void trajeto() {
    salvatrajeto = 1;
}
void fimtrajeto() {
    salvatrajeto = 2;
}
