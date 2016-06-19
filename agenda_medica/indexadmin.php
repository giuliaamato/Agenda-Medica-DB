<?php
	
	session_start();
	include('db_config.php');

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){


		session_unset();
		session_destroy();

		header("Location: loginadmin.php");
		die();

	}

	if (!isset($_SESSION['username']) && !$_SESSION['logged_as']='admin'){

		header("Location: loginAdmin.php");
		die();

	}



?>

<!doctype html>
<html>
<head>
    <title></title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    
</head>


<body>

<nav class="navbar navbar-inverse">
  <div class="navbar-header">
    <a class="navbar-brand" href="#">Admin</a>
  </div>
  <?php echo "<p class='navbar-text'>Loggato come ".$_SESSION['username']."</p>" ?>
  <form method='POST' action='#'><button type="submit" class="btn btn-default navbar-btn">Logout</button></form>
</nav>

<div class="container">

<?php

	$db_conn = new DBConfig();

	$row = $db_conn->db_query("SELECT CittaSede,Codice FROM ASL WHERE ASL.Codice=(SELECT CodiceASL FROM Informazioni AS I WHERE I.CodiceFiscale='".$_SESSION['codice_fiscale']."' )");

	$info_ASL = $row[0];

	echo "<h1>Amministrazione ASL di ".$info_ASL['CittaSede']."</h1>";
	
?>

	<h2>Dottori</h2>
<?php

	$dottori = $db_conn->db_query("SELECT I.CodiceFiscale,I.Nome,I.Cognome FROM Informazioni AS I INNER JOIN Dottore ON I.CodiceFiscale=Dottore.CodiceFiscale AND I.CodiceASL=".$info_ASL['Codice']."");

	if (count($dottori)>0){

		echo "<table class='table table-bordered'>";
		echo "<tr>";
		echo "<th> CF Dottore </th>";
		echo "<th> Nome e Cognome </th>";
		echo "</tr>";

		for ($i=0; $i < count($dottori); $i++) { 
			$dott = $dottori[$i];
			echo "<tr>";
			echo "<td><form action='info_dottore.php' method='GET'><input type='hidden' name='cf_dottore' value='".$dott['CodiceFiscale']."'/><button type='submit' class='btn btn-primary'>".$dott['CodiceFiscale']."</button></form></td>";
			echo "<td>".$dott['Nome']." ".$dott['Cognome']."</td>";
			echo "</tr>";
		}
		
		echo "</table>";


	}

	echo "<h2>Infermieri</h2>";

	$infermieri = $db_conn->db_query("SELECT I.CodiceFiscale,I.Nome,I.Cognome FROM Informazioni AS I INNER JOIN Infermiere ON I.CodiceFiscale=Infermiere.CodiceFiscale AND I.CodiceASL=".$info_ASL['Codice']."");

	if (count($infermieri)>0){

		echo "<table class='table table-bordered'>";
		echo "<tr>";
		echo "<th> CF Infermiere </th>";
		echo "<th> Nome e Cognome </th>";
		echo "</tr>";

		for ($i=0; $i < count($infermieri); $i++) { 
			$inf = $infermieri[$i];
			echo "<tr>";
			echo "<td><form action='info_infermiere.php' method='GET'><input type='hidden' name='cf_infermiere' value='".$inf['CodiceFiscale']."'/><button type='submit' class='btn btn-primary'>".$inf['CodiceFiscale']."</button></form></td>";
			echo "<td>".$inf['Nome']." ".$inf['Cognome']."</td>";
			echo "</tr>";
		}
		
		echo "</table>";


	}


?>


</div>
</body>
</html>
