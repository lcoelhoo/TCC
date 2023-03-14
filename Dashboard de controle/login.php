<!DOCTYPE html>

<html data-wf-page="5f178495834edad277bcf96c" data-wf-site="5f178495834edab0d0bcf96b">
<head>
  <meta charset="utf-8">
  <title>Enduro Login</title>
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
<body class="body">
  <h1 class="heading">DASHBOARD ENDURO FIM</h1>
  <div class="div-block">
    <div class="div-block-2">
      <div class="text-block">Faça o login para continuar</div>
      <div class="w-form">
        <form  id="email-form" name="email-form" method="post" action="autentica-login.php">
          <input type="text" class="text-field w-input" maxlength="256" name="Usuario" placeholder="Usuário" id="senha-2" required="">
          <input type="password" class="text-field w-input"  maxlength="256" name="Senha" placeholder="Senha" id="senha" required="">
          <input type="submit" value="Entrar"  class="submit-button w-button"></form>

            <?php
            if(isset($_GET['login'])){
              $status = $_GET['login'];
            }else{
              $status = "login";
            }
            
            if($status=="erro"){
            ?>
              <div style="color:#01c8e9; margin-top: 5px;">Dados de login incorretos.</div>
            <?php }?>

      </div>
    </div>
  </div>
  <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=5f178495834edab0d0bcf96b" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="js/webflow.js" type="text/javascript"></script>
  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
</body>
</html>