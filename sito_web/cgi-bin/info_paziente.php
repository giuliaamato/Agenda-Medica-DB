<?php
  
  session_start();

  if (!isset($_SESSION['username']) || !$_SESSION['logged_as'] == 'dottore'){

    header("Location: index.html");
    die();

  }

?>


<!doctype html>
<html>
<head>
    <title>Amministrazione</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">


</head>

<body>



  <nav class="navbar navbar-inverse">
  <div class="navbar-header">
    <a class="navbar-brand" href="index.html">Pagina iniziale</a>
  </div>
  <?php echo "<p class='navbar-text'>Loggato come ".$_SESSION['username']."</p>" ?>
  <form method='POST' action='#'><button type="submit" class="btn btn-default navbar-btn">Logout</button></form>
  </nav>






<div class="container">


<?php

  include('db_config.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['cf_paziente'])){

    $db_conn = new DBConfig();

    $cod_fiscale = $_GET['cf_paziente'];

    $rows = $db_conn->db_query("SELECT * FROM Informazioni AS I WHERE I.CodiceFiscale='".$cod_fiscale."';");

    echo "<p><a role='button' class='btn btn-primary' href='indexdottore.php'>Torna all'agenda</a></p>";

    if (count($rows)>0){

      $persona = $rows[0];

      echo "<h1>Informazioni paziente: ".$persona['CodiceFiscale']."</h1>";

      echo "<div class='well'>";

      echo "<h4>Nome: <span class='lead'>".$persona['Nome']."</span></h4>";
      echo "<h4>Cognome: <span class='lead'>".$persona['Cognome']."</span></h4>";
      echo "<h4>Data di nascita: <span class='lead'>".$persona['DataNascita']."</span></h4>";
      echo "<h4>Email: <span class='lead'>".$persona['Email']."</span></h4>";
      echo "<h4>Telefono: <span class='lead'>".$persona['Telefono']."</span></h4>";
      echo "<h4>Città di residenza: <span class='lead'>".$persona['CittaResidenza']."</span></h4>";
      echo "<h4>Città di nascita: <span class='lead'>".$persona['CittaNascita']."</span></h4>";
      echo "<h4>Indirizzo: <span class='lead'>".$persona['Indirizzo']."</span></h4>";
      echo "</div>";

      $rows = $db_conn->db_query("SELECT * FROM VisitaMedica AS VM WHERE VM.CFPaziente='".$cod_fiscale."' AND VM.TipoPrenotazione=0;");



      echo "<h2>Visite mediche effettuate</h2>";

      if (count($rows)>0){

        echo "<div class='well'>";
        echo "<table class='table'>";
        echo "<tr>";
        echo "<th>Data/Ora visita</th>";
        echo "<th>Dottore</th>";
        echo "<th>Infermiere</th>";
        echo "<th>Referto</th>";
        echo "</tr>";

        for ($i=0; $i < count($rows) ; $i++) { 
          
          $v = $rows[$i];

          echo "<tr>";

          echo "<td>".$v['Data']."</td>";

          if (isset($v['CFDottore'])){

            if ($v['CFDottore'] != $_SESSION['codice_fiscale']){

              echo "<td><form action='info_dottore.php' method='GET'><input type='hidden' name='cf_dottore' value='".$v['CFDottore']."'/><button class='btn btn-primary'>".$v['CFDottore']."</button></form></td>";


            } else {


              echo "<td>".$v['CFDottore']."</td>";
            }

          } else {
            echo "<td>Dottore non disponibile</td>";
          }


          if (isset($v['CFInfermiere'])){
            echo "<td><form action='info_infermiere.php' method='GET'><input type='hidden' name='cf_infermiere' value='".$v['CFInfermiere']."'/><button class='btn btn-primary'>".$v['CFInfermiere']."</button></form></td>";
          } else {
            echo "<td>Infermiere non disponibile</td>";
          }

          

          if (isset($v['CodiceReferto'])){
            echo "<td><form action='info_referto.php' method='GET'><input type='hidden' name='cod_referto' value='".$v['CodiceReferto']."'/><input type='hidden' name='cf_paziente' value='".$v['CFPaziente']."'\><button class='btn btn-primary'>Referto n.".$v['CodiceReferto']."</button></form></td>";
          } else {
            echo "<td>Referto non disponibile</td>";
          }

            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";

      } else {

        echo "<p>Nessuna visita effettuata</p>";

      }

    }

  }


?>
  

</div>
</body>
</html>
