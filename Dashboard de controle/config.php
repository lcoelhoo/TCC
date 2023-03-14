<?php
	
	include "conectar.php";

	$sql = "SELECT * FROM login";
 	$resultado = mysqli_query($mysqli_connection,$sql);


 	while ($registro = mysqli_fetch_array($resultado))
	 {
	   $nome = $registro['nomeLogin'];
	   $sobrenome = $registro['usuarioLogin'];
	   $sexo = $registro['senhaLogin'];
	 }

?>