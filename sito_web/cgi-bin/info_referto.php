<?php
  
  session_start();

  if (!isset($_SESSION['username']) && !$_SESSION['logged_in'] == true){

    header("Location: index.html");
    die();

  }

?>


<!doctype html>
<html>
<head>
    <title>Agenda Medica</title>

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

	if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['cod_referto'])){


		$db_conn = new DBConfig();

		$cod_referto = $_GET['cod_referto'];

		$rows = $db_conn->db_query("SELECT Contenuto FROM Referto WHERE Codice=".$cod_referto.";");

		$testo = $rows[0]['Contenuto'];

		if (isset($_GET['cf_paziente'])){

		echo "<form method='GET' action='info_paziente.php'><input type='hidden' name='cf_paziente' value='".$_GET['cf_paziente']."'/><button class='btn btn-primary'>Torna al paziente</button></form>";

		} else {
			echo "<p><a role='button' class='btn btn-primary' href='".$_SERVER['HTTP_REFERER']."'>Torna alla pagina precedente</a></p>";
		}

		echo "<h1>Referto numero ".$cod_referto."</h1>";
		echo "<div class='well'>";
		echo "<p>".$testo."</p>";
		echo "</div>";



	}



?>	

	



</div>

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>
