<?php header('Content-type: application/json');

// Verifica se existe a variável idPiloto
if (isset($_GET["idcoo"])) {
    $idpilotocoordenadas = $_GET["idcoo"];

    $conexao = new MySQLi('localhost', 'root', '', 'enduro');

    // Verifica se a variável está vazia
    if (empty($idpilotocoordenada)) {
        $sql = "SELECT * FROM `localizacao` where (CodPiloto ='$idpilotocoordenadas')";
    } else {
        $sql = "SELECT * FROM `localizacao` where (CodPiloto ='$idpilotocoordenadas')";
    }


    sleep(1);
    $result = mysqli_query($conexao, $sql);
    $cont = mysqli_affected_rows($conexao);

    // Verifica se a consulta retornou linhas 
    if ($cont > 0) {


        $result1 = array();
        while ($linha = mysqli_fetch_array($result)) {
        array_push($result1, array($linha["Longitude"],$linha["Latitude"]));
        }

        echo json_encode($result1);


    }
}
?>