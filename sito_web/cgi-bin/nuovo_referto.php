<?php
	
	session_start();

	include("db_config.php");




	if (!isset($_SESSION['username']) && !$_SESSION['logged_as']=='dottore'){

		header("Location: logindottore.php");
		die();

	}

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['visita'])){

    setcookie("visita",$_POST['visita'], time()+31536000);

  }


  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['testo_referto'])){

    // INSERISCI IL REFERTO
    $db_conn = new DBConfig();
    
    $db_conn->db_query("CALL insert_referto('".$_POST['testo_referto']."',".$_COOKIE['visita'].")");


    setcookie("visita", "", time() - 3600);

    header("Location: indexdottore.php");

  }


?>

<!doctype html>
<html>
<head>
    <title>Nuovo referto</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    
</head>


<body>



<div class="container">

	<h1>Aggiunta referto medico</h1>

	<a class='btn btn-danger' href='indexdottore.php'>Torna all'agenda</a>

	<br /><br />

	<form method='POST' action='nuovo_referto.php'>

		<div class="form-group">
      <label for="testo">Referto:</label>
      <textarea name='testo_referto' class="form-control" rows="10" id="testo"></textarea>

    </div>
    <button type='submit' class='btn btn-primary'>Inserisci referto</button>
	</form>



</div>

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>
