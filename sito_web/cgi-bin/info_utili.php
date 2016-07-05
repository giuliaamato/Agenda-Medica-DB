<?php

	session_start();

	include("db_config.php");

	if (!$_SESSION['username'] && !$_SESSION['logged_as'] == 'admin'){
		header("Location: index.html");
		die();
	}


?>

<!doctype html>
<html>
<head>
    <title>Info Generali</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    
</head>
<body>
<div class='container'>
	
	<h1>Informazioni generali ASL del Veneto</h1>

	<h2>Visite effettuate</h2>
	<?php

		$conn = new DBConfig();

		$rows = $conn->db_query("SELECT * FROM visite_effettuate");

		

		if (count($rows)>0){

			echo "<ul class='list-group'>";
			echo "<li class='list-group-item'><b>Infermiere tirocinante ".$rows[0]['CodiceFiscale']." ha partecipato a ".$rows[0]['Visite']." visite</b></li>";
			echo "<li class='list-group-item'><b>Dottore ".$rows[1]['CodiceFiscale']." ha effettuato ".$rows[1]['Visite']." visite di priorità di tipo 'L' </b></li>";
			echo "<li class='list-group-item'><b>Dottore ".$rows[2]['CodiceFiscale']." ha effettuato ".$rows[2]['Visite']." visite di priorità di tipo 'H' </b></li>";
			echo "</ul>";

		}

	?>

	<h2>Dottori con stipendio superiore a 30000 e nome utente particolare con account la cui scadenza è a ottobre</h2>

	<?php

		$rows = $conn->db_query("SELECT * FROM 	mostra_dottri_stipendio");

		echo "<table class='table table-bordered'>";
		echo "<tr>";
		echo "<th>Nome utente</th>";
		echo "<th>Codice Fiscale</th>";
		echo "<th>Stipendio(Annuo)</th>";
		echo "</tr>";

		for ($i=0; $i < count($rows); $i++) { 
			$dott = $rows[$i];
			
			echo "<tr>";
			echo "<td>".$dott['NomeUtente']."</td>";
			echo "<td>".$dott['CodiceFiscale']."</td>";
			echo "<td>".$dott['Stipendio']."</td>";
			echo "</tr>";

		}

		echo "</tr>";
		echo "</table>";

	?>

	<h2> Dottori che hanno visitato nel mese precedente </h2>

	<?php

		$rows = $conn->db_query("SELECT * FROM conta_visite");

		

		echo "<table class='table table-bordered'>";
		echo "<tr>";
		echo "<th>Codice Fiscale</th>";
		echo "<th>Nome</th>";
		echo "<th>Cognome</th>";
		echo "<th> # Visite </th>";
		echo "</tr>";

		for ($i=0; $i < count($rows); $i++) { 
			$dott = $rows[$i];
			
			echo "<tr>";
			echo "<td>".$dott['CFdottore']."</td>";
			echo "<td>".$dott['Nome']."</td>";
			echo "<td>".$dott['Cognome']."</td>";
			echo "<td>".$dott['Visite_Effettuate']."</td>";
			echo "</tr>";

		}

		echo "</tr>";
		echo "</table>";

	?>

	<h2> ASL con maggior numero di tirocinanti donne e uomini </h2>

	<?php

		$rows = $conn->db_query("SELECT * FROM tirocinanti");

		$asl = $conn->db_query("SELECT ASL.CittaSede FROM ASL WHERE ASL.Codice=".$rows[0]['CodiceASL']." OR ASL.Codice=".$rows[1]['CodiceASL']);

		echo "<p>La ASL con il maggior numero di infermieri tirocinanti maschi ha: <b>".$rows[0]['conta']."</b> infermieri tirocinanti maschi</p>";
		echo "<p></p>La ASL con il maggior numero di infermiere tirocinanti ha: <b>".$rows[1]['conta']."</b> infermiere tirocinanti</p>";

	?>

	<h2> Dottori che hanno effettuato meno di 5 visite mediche nel mese precedente</h2>

	<?php

		$rows = $conn->db_query("SELECT * FROM visite_mese_precedente");

		

		echo "<table class='table table-bordered'>";
		echo "<tr>";
		echo "<th>CodiceFiscale</th>";
		echo "<th>Nome</th>";
		echo "<th>Cognome</th>";
		echo "<th> # Visite </th>";
		echo "<th> ASL </th>";
		echo "</tr>";

		for ($i=0; $i < count($rows); $i++) { 
			
			$dott = $rows[$i];

			$asl = $conn->db_query("SELECT ASL.CittaSede FROM ASL WHERE ASL.Codice=".$dott['CodiceASL']);
			
			echo "<tr>";
			echo "<td>".$dott['CodiceFiscale']."</td>";
			echo "<td>".$dott['Nome']."</td>";
			echo "<td>".$dott['Cognome']."</td>";
			echo "<td>".$dott['NumeroVisite']."</td>";
			echo "<td>".$asl[0]['CittaSede']."</td>";
			echo "</tr>";

		}

		echo "</tr>";
		echo "</table>";

	?>		

	

</div>

</body>
