<?php 
  session_start();

  if(isset($_SESSION['statuslogin']) && $_SESSION['statuslogin']=="logado"){
   include "conectar.php";


    $result_competicao = "SELECT * FROM competicao";
    $result_competicao = mysqli_query($mysqli_connection, $result_competicao);



    $result_categoria = "SELECT * FROM categoria";
    $result_categoria = mysqli_query($mysqli_connection, $result_categoria);


?>
<!DOCTYPE html>
<html data-wf-page="5f178926f74c47cc3118e835" data-wf-site="5f178495834edab0d0bcf96b">
<head>
  <meta charset="utf-8">
  <title>Selecionar competição</title>
  <meta content="Selecionar competição" property="og:title">
  <meta content="Selecionar competição" property="twitter:title">
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
  <div class="div-block-3 _1">
    <div class="div-block-4">
      <h2 class="heading-2">Selecione as opções abaixo.</h2>
      <div>
        <div class="w-form">
          <form id="email-form" name="email-form" method="post" action="relatorio-competicao.php" class="form-2">





          <select id="nomecompeticao" name="nomecompeticao" class="select-field w-select" required>
            <option disabled>Competições</option>
                <?php
               while($row = mysqli_fetch_assoc($result_competicao))
              {     
              $NomeCompeticao = $row['NomeCompeticao']; 
              $idCompeticao = $row['idCompeticao']; ?>
            <option value="<?php echo $idCompeticao; ?>"><?php echo $NomeCompeticao; ?></option>
             <?php }?>
          </select>



          <select id="categoria" name="categoria"  class="select-field w-select" required>
            <option disabled>Categorias</option>
             <?php
               while($row2 = mysqli_fetch_assoc($result_categoria))
              {     
              $CodCategoria = $row2['idCategoria'];
              $NomeCategoria = $row2['NomeCategoria']; ?>
            <option value="<?php echo $CodCategoria; ?>"><?php echo $NomeCategoria; ?></option>
             <?php }?>
          </select>






          <input type="submit" value="Ver informações" class="submit-button-2 w-button"></form>

        </div>
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