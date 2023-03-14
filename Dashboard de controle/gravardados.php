<?php

 session_start();
  echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";

$conexao = new MySQLi('localhost', 'root', '', 'endur');
$arquivo = fopen("registrosarduino1.txt", "r");
$contadorGlobal = 0;

while (!feof($arquivo)){

	$linhas = fgets($arquivo);
	$dados = explode("*", $linhas);
	$coordenadas = array($linhas);
	$qtdarray = count($dados);
	$contadorGlobal++;
}

$teste = file_get_contents('registrosarduino1.txt');
$array = array_filter(explode("\n", $teste));
$aspas_tratadas1 = explode("*", $array[$contadorGlobal-2]);
$campo = $aspas_tratadas1[0];
$horaatual = date('H:i:s');

echo "<br>SQL ATUAL ------ ".$campo;
echo "<br>SQL GRAVADO - ".$_SESSION['sqlgravado'];
 
 if ($campo <> $_SESSION['sqlgravado']) {
$_SESSION['sqlgravado'] = $campo;
$campo = str_replace("horaatual", $horaatual, $campo);
$sql1 = $campo;

if($conexao -> query($sql1)){
 echo "<br> Dados inseridos com sucesso!<br>";}else
 {echo "<BR>Erro!<br>";};}else
 {echo "<br><br>Dados já inseridos anteriormente!";}
?>