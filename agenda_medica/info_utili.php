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

		$rows = $conn->db_query("SELECT MAX(VisiteEffettuate) AS Visite, T.CFInfermiere AS CodiceFiscale
		FROM (SELECT VM.CFInfermiere, VM.CFDottore, COUNT(*) VisiteEffettuate 
		FROM Infermiere i, VisitaMedica VM 
		WHERE i.Tirocinante = 1 AND VM.CFInfermiere = i.CodiceFiscale 
		GROUP BY VM.CFInfermiere, VM.CFDottore ) AS T 
		UNION SELECT MAX(VisiteEffettuate), T2.CFDottore 
		FROM (SELECT VM.CFDottore, COUNT(*) VisiteEffettuate 
		FROM VisitaMedica VM WHERE VM.TipoPrenotazione = 1 
		AND VM.Priorita = 'L' GROUP BY VM.CFDottore ) AS T2 
		UNION SELECT MAX(VisiteEffettuate), T3.CFDottore FROM 
		(SELECT VM.CFDottore, COUNT(*) VisiteEffettuate FROM VisitaMedica VM 
		WHERE VM.TipoPrenotazione = 1 AND VM.Priorita = 'H' GROUP BY VM.CFDottore ) AS T3");

		

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

		$rows = $conn->db_query("SELECT D.NomeUtente, D.CodiceFiscale, Doct.Stipendio
		FROM DatiAccesso D JOIN Dottore Doct
		ON D.CodiceFiscale = Doct.CodiceFiscale AND D.DataScadenza BETWEEN '2016-01-01' AND '2016-10-01'
		AND Doct.Stipendio>30000 AND D.NomeUtente LIKE '%ca_%' AND Doct.OraInizio BETWEEN '9:00:00' AND '13:30:00'
		AND Doct.OraFine BETWEEN '13:00:00' AND '15:45:00' AND Doct.CodiceFiscale 
		NOT IN (SELECT VM.CFDottore FROM VisitaMedica VM, Informazioni I 
		WHERE VM.CFdottore=I.CodiceFiscale)");

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

	<h2> Dottori che hanno visitato a maggio </h2>

	<?php

		$rows = $conn->db_query("SELECT VM.CFDottore, I.Nome, I.Cognome, COUNT(VM.CFDottore) Visite_Effettuate 
		FROM VisitaMedica VM JOIN Informazioni I ON VM.CFDottore = I.CodiceFiscale 
		WHERE VM.CFDottore IN ( SELECT VM.CFDottore FROM VisitaMedica VM WHERE VM.TipoPrenotazione = 1 
		AND VM.Data BETWEEN '2016-05-01 00:00:00' AND '2016-05-31 23:59:59') 
		GROUP BY VM.CFDottore");

		

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
			echo "<td>".$dott['CFDottore']."</td>";
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

		$rows = $conn->db_query("SELECT T1.CodiceASL, MAX(T1.CountInf) Count FROM (SELECT COUNT(Infermiere.CodiceFiscale) 
		AS CountInf,Informazioni.CodiceASL FROM Infermiere JOIN Informazioni 
		ON Infermiere.CodiceFiscale=Informazioni.CodiceFiscale WHERE Infermiere.Tirocinante=1 
		AND CAST(Informazioni.DataNascita as date)>1970-01-01 AND Informazioni.Sesso='M' 
		GROUP BY Informazioni.CodiceASL) T1 UNION SELECT T2.CodiceASL, MAX(T2.CountInf)
		FROM (SELECT COUNT(Infermiere.CodiceFiscale) AS CountInf,Informazioni.CodiceASL 
		FROM Infermiere JOIN Informazioni ON Infermiere.CodiceFiscale=Informazioni.CodiceFiscale 
		WHERE Infermiere.Tirocinante=1 AND CAST(Informazioni.DataNascita as date)>1970-01-01 
		AND Informazioni.Sesso='F' GROUP BY Informazioni.CodiceASL) T2");

		$asl = $conn->db_query("SELECT ASL.CittaSede FROM ASL WHERE ASL.Codice=".$rows[0]['CodiceASL']." OR ASL.Codice=".$rows[1]['CodiceASL']);

		

		echo "<table class='table table-bordered'>";
		echo "<tr>";
		echo "<th> Codice ASL</th>";
		echo "<th>Nome ASL</th>";
		echo "<th>Tirocinanti</th>";
		echo "</tr>";

		echo "<tr>";
		echo "<td>".$rows[0]['CodiceASL']."</td>";
		echo "<td>".$asl[0]['CittaSede']."</td>";
		echo "<td>".$rows[0]['Count']." infermieri uomini</td>";
		echo "<tr>";
		echo "<td>".$rows[0]['CodiceASL']."</td>";

		if (count($asl)>1){
			echo "<td>".$asl[1]['CittaSede']."</td>";
		} else {
			echo "<td>".$asl[0]['CittaSede']."</td>";
		}

		echo "<td>".$rows[0]['Count']." infermieri donne</td>";

		echo "</tr>";
		echo "</table>";

	?>

	<h2> Dottori che hanno effettuato meno di 5 visite mediche nel mese precedente</h2>

	<?php

		$rows = $conn->db_query("SELECT DISTINCT Informazioni.Nome, Informazioni.Cognome, Informazioni.CodiceASL, 
		Informazioni.CodiceFiscale, COUNT(*) NumeroVisite FROM VisitaMedica JOIN Informazioni 
		ON Informazioni.CodiceFiscale = VisitaMedica.CFDottore WHERE TipoPrenotazione=1 
		AND EXTRACT(YEAR FROM VisitaMedica.Data)=EXTRACT(YEAR FROM DATE_SUB(CURDATE(),INTERVAL 1 MONTH))
		AND EXTRACT(MONTH FROM VisitaMedica.Data)=EXTRACT(MONTH FROM DATE_SUB(CURDATE(),INTERVAL 1 MONTH)) 
		GROUP BY CFDottore HAVING COUNT(*)<5");

		

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

	?>

</div>

</body>