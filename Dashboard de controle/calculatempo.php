<?php
 include "conectar.php";

$tempo1= 0;
$tempo2= 0;
 $time01_tot = 99.99;
$tempoCTinicial = "SELECT Tempo from cronometragem,  piloto,  competicao, categoria where (CodPiloto = idPiloto) and (CTinicial = 1) and (idPiloto = $idPilotoselect) and (Volta = 1)  and  (CodCompeticao = $nomecompeticao ) and (codCategoria = $categoria)";
$result_tempoincial = mysqli_query($mysqli_connection, $tempoCTinicial);
while($row = mysqli_fetch_assoc($result_tempoincial)){
$tempo1 = $row["Tempo"];

}  

$tempoCTfinal = "SELECT Tempo from cronometragem,  piloto,  competicao, categoria where (CodPiloto = idPiloto) and (CTfinal = 1) and (idPiloto = $idPilotoselect) and (Volta = 1)  and  (CodCompeticao = $nomecompeticao ) and (codCategoria = $categoria)";
$result_tempofinal = mysqli_query($mysqli_connection, $tempoCTfinal);
while($row = mysqli_fetch_assoc($result_tempofinal)){
$tempo2 = $row["Tempo"];
 $time01_tot = 00.00;
}   

 if ($tempo1 <> "" && $tempo2 <> "") {
 $date_time  = new DateTime($tempo2);
 $diff       = $date_time->diff( new DateTime($tempo1));
 $tempo1 = $diff->format('00:%i:%s');
 $time01 = strtotime($tempo1);
 $time01_tot = date('i', $time01).".".date('s', $time01);}
 $time01_tot = floatval($time01_tot);






// ET1 vota 1
$tempo3= 0;
$tempo4= 0;
 $time02_tot2 = 99.99;
$tempoET1inicial = "SELECT Tempo from cronometragem,  piloto,  competicao, categoria where (CodPiloto = idPiloto) and (ET1inicial = 1) and (idPiloto = $idPilotoselect) and (Volta = 1)  and  (CodCompeticao = $nomecompeticao ) and (codCategoria = $categoria)";
$result_tempoincial = mysqli_query($mysqli_connection, $tempoET1inicial);
while($row = mysqli_fetch_assoc($result_tempoincial)){
$tempo3 = $row["Tempo"];
 $time02_tot2 = 00.00;
 }  

$tempoET1final = "SELECT Tempo from cronometragem,  piloto,  competicao, categoria where (CodPiloto = idPiloto) and (ET1final = 1) and (idPiloto = $idPilotoselect) and (Volta = 1)  and  (CodCompeticao = $nomecompeticao ) and (codCategoria = $categoria)";
$result_tempofinal = mysqli_query($mysqli_connection, $tempoET1final);
while($row = mysqli_fetch_assoc($result_tempofinal)){
$tempo4 = $row["Tempo"];
} 



 if ($tempo3 <> "" && $tempo4 <> "") {
 $date_time  = new DateTime($tempo4);
 $diff       = $date_time->diff( new DateTime($tempo3));
 $tempo3 = $diff->format('00:%i:%s');

 $time02 = strtotime($tempo3);
 $time02_tot2 = date('i', $time02).".".date('s', $time02);}
$time02_tot = floatval($time02_tot2);






// CT1 vota 2
$tempo5= 0;
$tempo6= 0;
$time03_tot3 = 99.99;
$tempoCTinicial2 = "SELECT Tempo from cronometragem,  piloto,  competicao, categoria where (CodPiloto = idPiloto) and (CTinicial = 1) and (idPiloto = $idPilotoselect) and (Volta = 2)  and  (CodCompeticao = $nomecompeticao ) and (codCategoria = $categoria)";
$result_tempoincial2 = mysqli_query($mysqli_connection, $tempoCTinicial2);
while($row = mysqli_fetch_assoc($result_tempoincial2)){
$tempo5 = $row["Tempo"];
$time03_tot3 = 00.00;
}  

$tempoCTfinal2 = "SELECT Tempo from cronometragem,  piloto,  competicao, categoria where (CodPiloto = idPiloto) and (CTfinal = 1) and (idPiloto = $idPilotoselect) and (Volta = 2)  and  (CodCompeticao = $nomecompeticao ) and (codCategoria = $categoria)";
$result_tempofinal2 = mysqli_query($mysqli_connection, $tempoCTfinal2);
while($row = mysqli_fetch_assoc($result_tempofinal2)){
$tempo6 = $row["Tempo"];
}   

 if ($tempo5 <> "" && $tempo6 <> "") {
 $date_time  = new DateTime($tempo6);
 $diff       = $date_time->diff( new DateTime($tempo5));
 $tempo5 = $diff->format('00:%i:%s');

 $time03 = strtotime($tempo5);
 $time03_tot3 = date('i', $time03).".".date('s', $time03);}
$time03_tot = floatval($time03_tot3);







// ET1 vota 2
$tempo8= 0;
$tempo7= 0;
$time04_tot4 = 99.99;
$tempoET1inicial2 = "SELECT Tempo from cronometragem,  piloto,  competicao, categoria where (CodPiloto = idPiloto) and (ET1inicial = 1) and (idPiloto = $idPilotoselect) and (Volta = 2)  and  (CodCompeticao = $nomecompeticao ) and (codCategoria = $categoria)";
$result_tempoincial2 = mysqli_query($mysqli_connection, $tempoET1inicial2);
while($row = mysqli_fetch_assoc($result_tempoincial2)){
$tempo8 = $row["Tempo"];
 $time04_tot4 = 00.00;
}  

$tempoET1final2 = "SELECT Tempo from cronometragem, competicao, categoria, piloto where (CodPiloto = idPiloto) and (ET1final = 1) and (idPiloto = $idPilotoselect) and (Volta = 2)  and  (idCompeticao = $nomecompeticao ) and (idCategoria = $categoria) ";
$result_tempofinal2 = mysqli_query($mysqli_connection, $tempoET1final2);
while($row = mysqli_fetch_assoc($result_tempofinal2)){
$tempo7 = $row["Tempo"];
} 


 if ($tempo7 <> "" && $tempo8 <> "") {
 $date_time  = new DateTime($tempo7 );
 $diff       = $date_time->diff( new DateTime($tempo8));
 $tempo8 = $diff->format('00:%i:%s');

 $time04 = strtotime($tempo8);
 $time04_tot4 = date('i', $time04).".".date('s', $time04);}
$time04_tot = floatval($time04_tot4);





?>