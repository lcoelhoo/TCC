
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
<html data-wf-page="5f178d11b99eb7efea44510a" data-wf-site="5f178495834edab0d0bcf96b">
<head>
  <meta charset="utf-8">
<!--   echo "<meta HTTP-EQUIV='refresh' CONTENT='10'>";
 -->
  <title>Relatório competição</title>
  <meta content="Relatório competição" property="og:title">
  <meta content="Relatório competição" property="twitter:title">
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
<body class="body-2">
  <h1 class="heading">DASHBOARD ENDURO FIM</h1>
  <div class="div-block-3">
    <div class="div-block-5">

      <div class="div-block-12">
        <div class="text-block-2">Categoria <?php echo $nomecat; ?> da competição <?php echo $nomecomp; ?></div>

         <form id="email-form" name="email-form" method="post" action="relatorio.php" class="form-2">
          <input type="hidden" id="categoria" name="categoria" value="<?php echo $categoria ?>">
          <input type="hidden"id="nomecompeticao" name="nomecompeticao" value="<?php echo $nomecompeticao?>">

          <input type="submit"value="Gerar Relatório" class="button-2 w-button">



      </div>
      <div class="div-block-11">


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

         $VelocidadeMedia1[] =  number_format($row["AVG(Velocidade)"], 2, '.', '');;

        }


        
        $valor_tot = $time01_tot+$time02_tot+$time03_tot+$time04_tot;



        $meuArray[] = ($valor_tot);
        asort($meuArray);
        $x = $x+1;     
        
        }

        $inicialposicao =0;
        foreach ($meuArray as $chave => $valor) {
        $inicialposicao = $inicialposicao+1;

                 $valor = number_format($valor, 2, '.', '');

        ?>


       <div class="div-block-6">
          <div class="div-block-7">
            <div class="text-block-3">#<?php echo $inicialposicao; ?></div>
            <div class="text-block-4"> <?php echo $piloto[$chave];?> - <?php echo $numeroPiloto[$chave]; ?></div>
          </div>
          <div class="div-block-8">
            <div class="div-block-16">
               <div class="div-block-10">
                <div class="text-block-5">Tempo de prova</div>

                <?php if($valor <> 399.96){ ?>
          <div class="text-block-6"><?php echo str_replace(".", ":", $valor);?></div>
          <?php }else{ ?>

          <div class="text-block-6">00:00</div>
          <?php } ?>

              </div>
            </div>
            <div class="div-block-17">
              <div class="div-block-10">
                <div class="text-block-5">Velocidade média</div>
                <div class="text-block-6"> <?php echo $VelocidadeMedia1[$chave];?> Km/H</div>
              </div>
              <div class="div-block-9"></div><a href="relatorio-piloto.php?id=<?php echo $idPiloto[$chave]; ?>&posicao=<?php echo $inicialposicao; ?>" class="button w-button">+</a></div>
          </div>
        </div>

        <?php 
      }?> 

        
      </div>
    </div>
  </div>
  <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=5f178495834edab0d0bcf96b" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="js/webflow.js" type="text/javascript"></script>
  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
</body>
</html>


<?php }else{

  header("Location: login.php");

}?>