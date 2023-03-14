<?php
	
	session_start();
	include "conectar.php";


	if((isset($_POST['Usuario'])) && (isset($_POST['Senha']))){

		 	if($_POST){    
			    $nome = preg_replace('/[^[:alpha:]_]/', '',$_POST['Usuario']);
			    $senha = preg_replace('/[^[:alnum:]_]/', '',$_POST['Senha']);
			}


		 	$result_usuario = "SELECT * FROM login WHERE Usuario = '$nome' AND Senha = '$senha' LIMIT 1";
	        $resultado_usuario = mysqli_query($mysqli_connection, $result_usuario);
	        $resultado = mysqli_fetch_assoc($resultado_usuario);

        if(isset($resultado)){
            $_SESSION['idLogin'] = $resultado['idLogin'];
            $_SESSION['Usuario'] = $resultado['Usuario'];
            $_SESSION['statuslogin'] = "logado";

            if($_SESSION['statuslogin'] == "logado"){
                header("Location: index.php");
            }
	        
	    }else{

        	header("Location: login.php?login=erro");
	    }

	}


?>