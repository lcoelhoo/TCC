<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<?php
	header('Content-Type: text/html; charset=UTF-8');
	$codigo_projeto = $_POST['codigo'];
	$diretorio = "../upload/projetos/".$codigo_projeto;


	if (!empty($_FILES)) {
		if (!is_dir($diretorio)) {
			mkdir($diretorio);
		}
		$arquivo = isset($_FILES['arquivo']) ? $_FILES['arquivo'] : FALSE;
		for ($controle = 0; $controle < count($arquivo['name']); $controle++){
			
			$ext = strtolower(substr($arquivo['name'][$controle],-4));
			$new_name = $controle."_".date("YmdHis") . $ext;

			$destino = $diretorio."/".$new_name;
			if(move_uploaded_file($arquivo['tmp_name'][$controle], $destino)){
				echo "<div class='alert alert-success' role='alert'> ".$arquivo['name'][$controle]." - Enviado com sucesso!</div>"; 
			}else{
				echo "<div class='alert alert-danger' role='alert'> ".$arquivo['name'][$controle]." - Falha ao enviar, envie novamente.</div>";
			}

			include "conectar.php";
			$sql = "INSERT INTO fotos (codProjetoFotos, urlFotos, liberaFotos) VALUES ";
			$sql .= "('$codigo_projeto', '$new_name', '1')";
	        mysqli_query($mysqli_connection,$sql) or die("Erro ao tentar cadastrar registro");
			mysqli_close($mysqli_connection);
			
		}
	} 
?>

<div align="center"><a href="javascript:window.close();" class="btn btn-warning">Fechar Tela</a></div>