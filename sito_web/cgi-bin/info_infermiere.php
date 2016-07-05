<?php
  
  session_start();

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){


    session_unset();
    session_destroy();

    header("Location: index.html");
    die();

  }


  if (!isset($_SESSION['username']) && (!$_SESSION['logged_as'] == 'dottore' || !$_SESSION['logged_as']=='admin')){

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
<?php

  
  if (isset($_SESSION['username'])){

    echo "<nav class='navbar navbar-inverse'>";
    echo "<div class='navbar-header'>";
    echo "<a class='navbar-brand' href='index.html'>Pagina iniziale</a>";
    echo "</div>";
    
    echo "<p class='navbar-text'>Loggato come ".$_SESSION['username']."</p>";

    if ($_SESSION['logged_as'] == 'dottore'){

    echo "<p class='navbar-text'><a href='indexdottore.php'>Agenda Medica</a></p>";
    echo "<form method='POST' action='#'><button type='submit' class='btn btn-default navbar-btn'>Logout</button></form>";
    
    } else {
      
      echo "<p class='navbar-text'><a href='indexadmin.php'>Amministrazione</a></p>";
      echo "<form method='POST' action='#'><button type='submit' class='btn btn-default navbar-btn'>Logout</button></form>";
    }


    echo "</nav>";
}

?>



<div class="container">


<?php

  include('db_config.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['cf_infermiere'])){

    $db_conn = new DBConfig();

    $cod_fiscale = $_GET['cf_infermiere'];

    $rows = $db_conn->db_query("SELECT * FROM Informazioni AS I WHERE I.CodiceFiscale='".$cod_fiscale."';");

    

    if (count($rows)>0){

      $persona = $rows[0];

      echo "<h1>Informazioni infermiere: ".$persona['CodiceFiscale']."</h1>";

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

      

    }

  }


?>
  

</div>
</body>
</html>
