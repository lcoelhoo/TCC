<?php 


    session_cache_limiter('private_no_expire');
    ini_set('display_errors', 0 );
    error_reporting(0);


  session_start();

  if(isset($_SESSION['statuslogin']) && $_SESSION['statuslogin']=="logado"){
     include "conectar.php";

    $nomecompeticao = $_POST["nomecompeticao"];
    $categoria = $_POST["categoria"];

    $result_categorianome = "SELECT NomeCategoria FROM categoria where idCategoria = $categoria";
    $result_categorianome = mysqli_query($mysqli_connection, $result_categorianome);
    while($row = mysqli_fetch_assoc($result_categorianome)){
    $nomecat = $row["NomeCategoria"];}

    $result_competicaoanome = "SELECT NomeCompeticao FROM competicao where idCompeticao = $nomecompeticao";
    $result_competicaoanome = mysqli_query($mysqli_connection, $result_competicaoanome);
    while($row = mysqli_fetch_assoc($result_competicaoanome)){
    $nomecomp = $row["NomeCompeticao"];}

?>

<!DOCTYPE html>

<html data-wf-page="5f8a329ea52e7063fe3c79d7" data-wf-site="5f178495834edab0d0bcf96b">
<head>
  <script type='text/javascript'>window.print();</script>
  <style type="text/css">
  @media print {
  body {-webkit-print-color-adjust: exact;}
  }
  </style>
  <meta charset="utf-8">
  <title>Relatorio</title>
  <meta content="Relatorio" property="og:title">
  <meta content="Relatorio" property="twitter:title">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta content="Webflow" name="generator">
  <link href="css/normalize.css" rel="stylesheet" type="text/css">
  <link href="css/webflow.css" rel="stylesheet" type="text/css">
  <link href="css/enduro.webflow.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
  <script type="text/javascript">WebFont.load({  google: {    families: ["Exo:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic"]  }});</script>
  <!-- [if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
  <script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
  <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon">
  <link href="images/webclip.png" rel="apple-touch-icon">
</head>
<body>
  <div>
    <h1 class="heading_relatorio relatorio_relatorio">Relatório categoria <?php echo $nomecat; ?> da competição <?php echo $nomecomp; ?></h1>
  </div>


    <?php 

        // $competicao = "SELECT * FROM piloto, competicao, categoria, cronometragem, ct1, et1, et2, et3 where (NomeCompeticao like '%".$nomecompeticao."%') AND (CodCategoria=idCategoria) AND (CodCompeticao=idCompeticao) AND (CodCronometragem=idcronometragem) AND (CodCt1=idct1) AND (CodEt1=idet1) AND (CodEt2=idet2) AND (CodEt3=idct3) AND (NomeCategoria like '%".$categoria."%')";

        $competicao = "SELECT * FROM piloto, competicao, categoria WHERE (idCompeticao = $nomecompeticao ) and (idCategoria = $categoria) and (CodCategoria = idCategoria) and (idCompeticao = CodCompeticao)";

        $result_competicao = mysqli_query($mysqli_connection, $competicao);
        while($row = mysqli_fetch_assoc($result_competicao)){   

         $x = 0;
          $piloto[] = $row["NomePiloto"];
          $numeroPiloto[] = $row["NumeroPiloto"];
          $idPilotoselect = $row["idPiloto"];
          $categoria2 = $row["idCategoria"];
          $competicao = $row["idCompeticao"];
          $idPiloto[] = $row["idPiloto"];


        include "calculatempo.php";

        $VelocidadeMedia = "SELECT AVG(Velocidade) FROM localizacao WHERE CodPiloto = $idPilotoselect";
        $VelocidadeMediatotal = mysqli_query($mysqli_connection, $VelocidadeMedia);
        while($row = mysqli_fetch_assoc($VelocidadeMediatotal)){

         $VelocidadeMedia1[] =  number_format($row["AVG(Velocidade)"], 2, '.', '');

        }



        
        $valor_tot = $time01_tot+$time02_tot+$time03_tot+$time04_tot;

        $meuArray[] = ($valor_tot);
        asort($meuArray);
        $x = $x+1;     
        
        }

        $inicialposicao =0;
        foreach ($meuArray as $chave => $valor) {
        $inicialposicao = $inicialposicao+1;



                // CT1 vota 1
        $tempo1= 0;
        $tempo2= 0;
        $tempoCTinicial = "SELECT Tempo from cronometragem,  piloto,  competicao, categoria where (CodPiloto = idPiloto) and (CTinicial = 1) and (idPiloto = $idPiloto[$chave]) and (Volta = 1)  and  (CodCompeticao = $nomecompeticao ) and (codCategoria = $categoria)";
        $result_tempoincial = mysqli_query($mysqli_connection, $tempoCTinicial);
        while($row = mysqli_fetch_assoc($result_tempoincial)){
        $tempo1 = $row["Tempo"];
        }  

        $tempoCTfinal = "SELECT Tempo from cronometragem,  piloto,  competicao, categoria where (CodPiloto = idPiloto) and (CTfinal = 1) and (idPiloto = $idPiloto[$chave]) and (Volta = 1)  and  (CodCompeticao = $nomecompeticao ) and (codCategoria = $categoria)";
        $result_tempofinal = mysqli_query($mysqli_connection, $tempoCTfinal);
        while($row = mysqli_fetch_assoc($result_tempofinal)){
        $tempo2 = $row["Tempo"];
        }   

         $time01_tot = 00.00;
         if ($tempo1 <> "" && $tempo2 <> "") {
         $date_time  = new DateTime($tempo2);
         $diff       = $date_time->diff( new DateTime($tempo1));
         $tempo1 = $diff->format('00:%i:%s');

         $time01 = strtotime($tempo1);
         $time01_tot = date('i', $time01).".".date('s', $time01);}
        $time01_tot1 = floatval($time01_tot);




        // ET1 vota 1
        $tempo3= 0;
        $tempo4= 0;
        $tempoET1inicial = "SELECT Tempo from cronometragem,  piloto,  competicao, categoria where (CodPiloto = idPiloto) and (ET1inicial = 1) and (idPiloto = $idPiloto[$chave]) and (Volta = 1)  and  (CodCompeticao = $nomecompeticao ) and (codCategoria = $categoria)";
        $result_tempoincial = mysqli_query($mysqli_connection, $tempoET1inicial);
        while($row = mysqli_fetch_assoc($result_tempoincial)){
        $tempo3 = $row["Tempo"];}  

        $tempoET1final = "SELECT Tempo from cronometragem,  piloto,  competicao, categoria where (CodPiloto = idPiloto) and (ET1final = 1) and (idPiloto = $idPiloto[$chave]) and (Volta = 1)  and  (CodCompeticao = $nomecompeticao ) and (codCategoria = $categoria)";
        $result_tempofinal = mysqli_query($mysqli_connection, $tempoET1final);
        while($row = mysqli_fetch_assoc($result_tempofinal)){
        $tempo4 = $row["Tempo"];
        } 


        $time02_tot2 = 00.00;
        if ($tempo3 <> "" && $tempo4 <> "") {
         $date_time  = new DateTime($tempo4);
         $diff       = $date_time->diff( new DateTime($tempo3));
         $tempo3 = $diff->format('00:%i:%s');

         $time02 = strtotime($tempo3);
         $time02_tot2 = date('i', $time02).".".date('s', $time02);}

        $time02_tot1 = floatval($time02_tot2);





        // CT1 vota 2
        $tempo5= 0;
        $tempo6= 0;
        $tempoCTinicial2 = "SELECT Tempo from cronometragem,  piloto,  competicao, categoria where (CodPiloto = idPiloto) and (CTinicial = 1) and (idPiloto = $idPiloto[$chave]) and (Volta = 2)  and  (CodCompeticao = $nomecompeticao ) and (codCategoria = $categoria)";
        $result_tempoincial2 = mysqli_query($mysqli_connection, $tempoCTinicial2);
        while($row = mysqli_fetch_assoc($result_tempoincial2)){
        $tempo5 = $row["Tempo"];
        }  

        $tempoCTfinal2 = "SELECT Tempo from cronometragem,  piloto,  competicao, categoria where (CodPiloto = idPiloto) and (CTfinal = 1) and (idPiloto = $idPiloto[$chave]) and (Volta = 2)  and  (CodCompeticao = $nomecompeticao ) and (codCategoria = $categoria)";
        $result_tempofinal2 = mysqli_query($mysqli_connection, $tempoCTfinal2);
        while($row = mysqli_fetch_assoc($result_tempofinal2)){
        $tempo6 = $row["Tempo"];
        }   

         $time03_tot3 = 00.00;
        if ($tempo5 <> "" && $tempo6 <> "") {
         $date_time  = new DateTime($tempo6);
         $diff       = $date_time->diff( new DateTime($tempo5));
         $tempo5 = $diff->format('00:%i:%s');

         $time03 = strtotime($tempo5);
         $time03_tot3 = date('i', $time03).".".date('s', $time03);}
        $time03_tot1 = floatval($time03_tot3);





        // ET1 vota 2
        $tempo8= 0;
        $tempo7= 0;
        $tempoET1inicial2 = "SELECT Tempo from cronometragem,  piloto,  competicao, categoria where (CodPiloto = idPiloto) and (ET1inicial = 1) and (idPiloto = $idPiloto[$chave]) and (Volta = 2)  and  (CodCompeticao = $nomecompeticao ) and (codCategoria = $categoria)";
        $result_tempoincial2 = mysqli_query($mysqli_connection, $tempoET1inicial2);
        while($row = mysqli_fetch_assoc($result_tempoincial2)){
        $tempo8 = $row["Tempo"];}  

        $tempoET1final2 = "SELECT Tempo from cronometragem, competicao, categoria, piloto where (CodPiloto = idPiloto) and (ET1final = 1) and (idPiloto = $idPiloto[$chave]) and (Volta = 2)  and  (idCompeticao = $nomecompeticao ) and (idCategoria = $categoria) ";
        $result_tempofinal2 = mysqli_query($mysqli_connection, $tempoET1final2);
        while($row = mysqli_fetch_assoc($result_tempofinal2)){
        $tempo7 = $row["Tempo"];
        } 

         $time04_tot4 = 00.00;
          if ($tempo7 <> "" && $tempo8 <> "") {
         $date_time  = new DateTime($tempo7 );
         $diff       = $date_time->diff( new DateTime($tempo8));
         $tempo8 = $diff->format('00:%i:%s');

         $time04 = strtotime($tempo8);
         $time04_tot4 = date('i', $time04).".".date('s', $time04);}
         $time04_tot = floatval($time04_tot4);

         $valor = number_format($valor, 2, '.', '');


        ?>



  <div class="div-block-18_relatorio">
    <div class="div-block-19">
      <div class="text-block-7_relatorio">#<?php echo $inicialposicao; ?> -</div>
      <div class="text-block-8_relatorio"><?php echo $piloto[$chave];?> - <?php echo $numeroPiloto[$chave]; ?></div>
    </div>
    <div class="div-block-21_relatorio">
      <div class="div-block-24_relatorio">
        <div class="div-block-22_relatorio">
          <div class="text-block-12_relatorio">Primeira Volta</div>
          <div class="div-block-20_relatorio">
            <div class="text-block-9_relatorio">TEMPO CT1</div>
            <div class="text-block-10_relatorio"><?php echo str_replace(".", ":", $time01_tot);?></div>
          </div>
          <div class="div-block-20_relatorio">
            <div class="text-block-9_relatorio">TEMPO ET1</div>
            <div class="text-block-10_relatorio"><?php echo str_replace(".", ":", $time02_tot2);?></div>
          </div>
        </div>
        <div class="div-block-22_relatorio">
          <div class="text-block-12_relatorio">Segunda volta</div>
          <div class="div-block-20_relatorio">
            <div class="text-block-9_relatorio">TEMPO CT1</div>
            <div class="text-block-10_relatorio"><?php echo str_replace(".", ":", $time03_tot3);?></div>
          </div>
          <div class="div-block-20_relatorio">
            <div class="text-block-9_relatorio">TEMPO ET1</div>
            <div class="text-block-10_relatorio"><?php echo str_replace(".", ":", $time04_tot4);?></div>
          </div>
        </div>
      </div>
      <div class="div-block-23_relatorio">
        <div class="div-block-20_relatorio other_relatorio">
          <div class="text-block-9_relatorio">TEMPO TOTAL</div>


          <?php if($valor <> 399.96){ ?>
          <div class="text-block-10_relatorio"><?php echo str_replace(".", ":", $valor);?></div>
          <?php }else{ ?>

          <div class="text-block-10_relatorio">00:00</div>
          <?php } ?>

        </div>
        <div class="div-block-20_relatorio other_relatorio">
          <div class="text-block-9_relatorio">VELOCIDADE MÉDIA</div>
          <div class="text-block-10_relatorio"><?php echo $VelocidadeMedia1[$chave];?> Km/H</div>
        </div>
      </div>
    </div>
  </div>

    <?php 
      }?> 



  <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=5f178495834edab0d0bcf96b" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="js/webflow.js" type="text/javascript"></script>
  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
</body>
</html>
<?php }else{

  header("Location: login.php");

}?>