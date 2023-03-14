<?php 

    ini_set('display_errors', 0 );
    error_reporting(0);

  session_start();

  if(isset($_SESSION['statuslogin']) && $_SESSION['statuslogin']=="logado"){
  include "conectar.php";

  $PilotoAtual = $_GET['id'];
  $PosicaoPilotoAtual = $_GET['posicao'];
  $sql = "SELECT * FROM piloto where idPiloto=".$PilotoAtual." ";
  $pilotoindividual = mysqli_query($mysqli_connection,$sql);
  $registro = mysqli_fetch_array($pilotoindividual);
  $qtd = mysqli_num_rows($pilotoindividual);
  
  if($qtd=="1"){


  $NomePiloto = $registro["NomePiloto"];
  $NumeroPiloto = $registro["NumeroPiloto"];
  $idPiloto = $registro["idPiloto"];
  $categoria = $registro["CodCategoria"];
  $nomecompeticao = $registro["CodCompeticao"];

      $result_categorianome = "SELECT idCategoria FROM categoria where idCategoria = $categoria";
    $result_categorianome = mysqli_query($mysqli_connection, $result_categorianome);
    while($row = mysqli_fetch_assoc($result_categorianome)){
    $nomecat = $row["idCategoria"];}

    $result_competicaoanome = "SELECT idCompeticao FROM competicao where idCompeticao = $nomecompeticao";
    $result_competicaoanome = mysqli_query($mysqli_connection, $result_competicaoanome);
    while($row = mysqli_fetch_assoc($result_competicaoanome)){
    $nomecomp = $row["idCompeticao"];}


  $titulo_pagina = $NomePiloto;

}

?>

<!DOCTYPE html>
<html data-wf-page="5f1792fef51b84f6b6a222e6" data-wf-site="5f178495834edab0d0bcf96b">
<head>
  <meta charset="utf-8">
  <title><?php echo $titulo_pagina; ?> - Relatório do Piloto</title>
  <meta content="<?php echo $titulo_pagina; ?> - Relatório do Piloto" property="og:title">
  <meta content="<?php echo $titulo_pagina; ?> - Relatório do Piloto" property="twitter:title">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta content="Webflow" name="generator">
  <link href="css/normalize.css" rel="stylesheet" type="text/css">
  <link href="css/webflow.css" rel="stylesheet" type="text/css">
  <link href="css/enduro.webflow.css" rel="stylesheet" type="text/css">
  <script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script>
  <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
  <script src='https://npmcdn.com/@turf/turf/turf.min.js'></script>
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
  <script type="text/javascript">WebFont.load({  google: {    families: ["Exo:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic"]  }});</script>
  <!-- [if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
  <script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
  <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon">
  <link href="images/webclip.png" rel="apple-touch-icon">
  <style>
        #map { width: 100%; height: 100%}

        .mapboxgl-ctrl-attrib-inner{display: none;}
    </style>
</head>

  <form style="display: none;">
   <input type="text" value="<?php echo $idPiloto; ?>" name="idPiloto" id="idcoo">
  </form>

<body class="body-2">
  <h1 class="heading">DASHBOARD ENDURO FIM</h1>
  <div class="div-block-3" style="height: auto; padding-bottom: 25px;">
    <div class="div-block-5">
      <div class="div-block-11">
        <div class="div-block-6" style="padding-bottom: 10px; padding-top: 10px;">
          <div class="div-block-7">
            <div class="text-block-3">#<?php echo $PosicaoPilotoAtual; ?></div>
            <div class="text-block-4"><?php echo $NomePiloto; ?> - <?php echo $NumeroPiloto; ?></div>
          </div>


         <?php 


      $VelocidadeMedia = "SELECT AVG(Velocidade) FROM localizacao WHERE CodPiloto = $idPiloto";
        $VelocidadeMediatotal = mysqli_query($mysqli_connection, $VelocidadeMedia);
        while($row = mysqli_fetch_assoc($VelocidadeMediatotal)){

         $VelocidadeMedia1 =  number_format($row["AVG(Velocidade)"], 2, '.', '');

        }
        

        include "calculatempopiloto.php";
         $valor_tot = number_format($valor_tot, 2, '.', '');



        ?>

          <div class="div-block-8">
            <div class="div-block-16">
              
               

                   <div class="div-block-21_relatorio">
      <div class="div-block-24_relatorio">
        <div class="div-block-22_relatorio">
          <div class="text-block-12_relatorio">Primeira Volta</div>
          <div class="div-block-20_relatorio">
            <div class="text-block-9_relatorio">TEMPO CT1</div>
            <div class="text-block-10_relatorio" style=" color: #01c8e9; "><?php echo str_replace(".", ":", $time01_tot11);?></div>
          </div>
          <div class="div-block-20_relatorio">
            <div class="text-block-9_relatorio">TEMPO ET1</div>
            <div class="text-block-10_relatorio" style=" color: #01c8e9; "><?php echo str_replace(".", ":", $time02_tot2);?></div>
          </div>
        </div>
        <div class="div-block-22_relatorio">
          <div class="text-block-12_relatorio">Segunda volta</div>
          <div class="div-block-20_relatorio">
            <div class="text-block-9_relatorio">TEMPO CT1</div>
            <div class="text-block-10_relatorio" style=" color: #01c8e9; "><?php echo str_replace(".", ":", $time03_tot3);?></div>
          </div>
          <div class="div-block-20_relatorio">
            <div class="text-block-9_relatorio">TEMPO ET1</div>
            <div class="text-block-10_relatorio" style=" color: #01c8e9; "><?php echo str_replace(".", ":", $time04_tot4);?></div>
          </div>
        </div>
      </div>
    </div>

    
            
            </div>
            <div class="div-block-10">
                <div class="text-block-5">Tempo Total</div>
                <div class="text-block-6"><?php echo str_replace(".", ":", $valor_tot);?> </div>
              </div>
            <div class="div-block-17">
              <div class="div-block-10">
                <div class="text-block-5">Velocidade média</div>
                <div class="text-block-6"><?php echo $VelocidadeMedia1; ?> Km/H</div>
              </div>
            </div>
          </div>
        </div>

 <script>


            /**
              * Função para criar um objeto XMLHTTPRequest
              */
             function CriaRequest() {
                 try{
                     request = new XMLHttpRequest();        
                 }catch (IEAtual){
                      
                     try{
                         request = new ActiveXObject("Msxml2.XMLHTTP");       
                     }catch(IEAntigo){
                      
                         try{
                             request = new ActiveXObject("Microsoft.XMLHTTP");          
                         }catch(falha){
                             request = false;
                         }
                     }
                 }
                  
                 if (!request) 
                     alert("Seu Navegador não suporta Ajax!");
                 else
                     return request;
             }
              
             /**
              * Função para enviar os dados
              */
              const getListMaps = function(){
                    return new Promise(function(resolve, reject){
                        // Declaração de Variáveis
                         var idPiloto   = document.getElementById("idcoo").value;
                         var result = document.getElementById("resultadocoordenadas");
                         var xmlreq = CriaRequest();
                         
                         // Iniciar uma requisição
                         xmlreq.open("GET", "buscacoordenadas.php?idcoo=" + idPiloto, true);

                         xmlreq.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                          
                         // Atribui uma função para ser executada sempre que houver uma mudança de ado
                         xmlreq.onreadystatechange = function(){
                              
                             // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
                             if (xmlreq.readyState == 4) {
                                 // Verifica se o arquivo foi encontrado com sucesso
                                 if (xmlreq.status == 200) {
                                  console.log(' CUIDA ESSE AQUI -> ',xmlreq);
                                  resolve(xmlreq.response);
                                 }else{
                                     reject(xmlreq)
                                 }
                             }
                         };
                         xmlreq.send(null);
                      });
              };


              window.onload = function getDados() {
                  
                 getListMaps().then(function(result){


                    result = result.split("[").join('');
              result = result.split("]").join('');
              result = result.split('"').join('');
              result = result.split(' ').join('');
              result = result.split(',');

            var resultArrayy = [];


            for(var i =0; i < result.length; i++){
              var index2 = i + 1;

              if(i%2 == 0){
                console.log("PAR");
                var item1 = parseFloat(result[i]);
                var item2 = parseFloat(result[index2]);
                var item = [item1, item2];
                resultArrayy.push(item);
              }else{
                console.log('else');
              }
            }


                  const line = turf.lineString(resultArrayy);

                  const len = turf.length(line, { units: "kilometers" });
                  document.getElementById('distancia').innerHTML = len.toFixed(2);



                 });
             }


    </script>

    <div id="resultadocoordenadas"></div>
   

        <div class="div-block-13">
          <div class="text-block-2" style="display: flex; align-items: center;">Percurso realizado | Distância&nbsp;<div id="distancia"></div> Km</div>
          <div class="div-block-14">
            <div class="html-embed w-embed w-iframe"><div id="map"></div></div>

            <script>

                    getListMaps().then(function(result){

                      result = result.split("[").join('');
                      result = result.split("]").join('');
                      result = result.split('"').join('');
                      result = result.split(' ').join('');
                      result = result.split(',');

                    var resultArrayy = [];


                    for(var i =0; i < result.length; i++){
                      var index2 = i + 1;

                      if(i%2 == 0){
                        console.log("PAR");
                        var item1 = parseFloat(result[i]);
                        var item2 = parseFloat(result[index2]);
                        var item = [item1, item2];
                        resultArrayy.push(item);
                      }else{
                        console.log('else');
                      }
                    }

                      console.log('array', resultArrayy);

                            mapboxgl.accessToken = 'pk.eyJ1IjoiaGF6emU0MCIsImEiOiJjajk2NHQzZHkwMHRjMnFxeHl2NWpzYWJzIn0.WgNk-5qfYQp79Oik51I4IQ';
                            
                  var map = new mapboxgl.Map({
                      container: 'map',
                      style: 'mapbox://styles/mapbox/satellite-v9',
                      center: [-53.3098645, -25.7829771],
                      zoom: 14
                  });
              
                  map.on('load', function () {
                      map.addSource('route', {
                          'type': 'geojson',
                          'data': {
                              'type': 'Feature',
                              'properties': {},
                              'geometry': {
                                  'type': 'LineString',
                                  'coordinates': resultArrayy
                              }
                          }
                      });

                      map.addLayer({
                          'id': 'route',
                          'type': 'line',
                          'source': 'route',
                          'layout': {
                              'line-join': 'round',
                              'line-cap': 'round'
                          },
                          'paint': {
                              'line-color': '#01c8e9',
                              'line-width': 3
                          }
                      });
                  });
          });


    </script>


          </div>
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

<!-- <script>
alert('Relatório do piloto não encontrado!');
window.location.href = "relatorio-competicao.php";
</script>
 -->

