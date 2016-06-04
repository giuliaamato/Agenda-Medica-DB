<?php
	
	session_start();

	include("db_config.php");

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){


		session_unset();
		session_destroy();

		header("Location: http://localhost/agenda_medica/logindottore.php");
		die();

	}


	if (!isset($_SESSION['username']) && !$_SESSION['logged_in']==true){

		header("Location: http://localhost/agenda_medica/logindottore.php");
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
    <a class="navbar-brand" href="http://localhost/agenda_medica/welcomepage.html">Pagina iniziale</a>
  </div>
  <?php echo "<p class='navbar-text'>Loggato come ".$_SESSION['username']."</p>" ?>
  <form method='POST' action='#'><button type="submit" class="btn btn-default navbar-btn">Logout</button></form>
</nav>

<div class="container">

	<a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
  		Mostra informazioni personali
	</a>

	<div class="collapse" id="collapseExample">
  		<div class="well">
  		<?php

			$cod_fiscale = $_SESSION['codice_fiscale'];

			$db_conn = new DBConfig();

			$rows = $db_conn->db_query("SELECT i.Nome, i.Cognome, i.Email, i.Telefono, i.CittaResidenza, a.CittaSede FROM Informazioni AS i,ASL AS a WHERE i.CodiceFiscale='".$cod_fiscale."' AND a.Codice=(SELECT CodiceASL FROM Informazioni WHERE CodiceFiscale='".$cod_fiscale."');");

			$persona = $rows[0];

			

			echo "<p><strong>Nome:</strong> ".$persona['Nome']."</p>";
			echo "<p><strong>Cognome:</strong> ".$persona['Cognome']."</p>";
			echo "<p><strong>Email:</strong> ".$persona['Email']."</p>";
			echo "<p><strong>Telefono:</strong> ".$persona['Telefono']."</p>";
			echo "<p><strong>Residenza:</strong> ".$persona['CittaResidenza']."</p>";
			echo "<p><strong>Sede ASL:</strong> ".$persona['CittaSede']."</p>";


		?>

    		
  		</div>
	</div>


	<h1>Agenda Medica</h1>

	<table class="table table-bordered">

		<tr>
			<th>Data Visita</th>
			<th>Ambulatorio</th>
			<th>Paziente</th>
			<th>Referto</th>
		</tr>

		<?php

			

			$rows = $db_conn->db_query("SELECT * FROM VisitaMedica AS VM WHERE VM.CFDottore='".$cod_fiscale."';");


			if (count($rows)>0){



				for ($i=0; $i < count($rows) ; $i++) { 

					$v = $rows[$i];

					echo "<tr>";
					echo "<td>".$v['Data']."</td>";
					echo "<td>".$v['Ambulatorio']."</td>";
					echo "<td><form method='GET' action='info_paziente.php'><input type='hidden' name='cf_paziente' value='".$v['CFPaziente']."'/><button class='btn btn-primary'>".$v['CFPaziente']."</button></form></td>";
					if (isset($v['CodiceReferto'])){
						echo "<td><form method='GET' action='info_referto.php'><input type='hidden' name='cod_referto' value='".$v['CodiceReferto']."'/><button class='btn btn-primary'>Referto n.".$v['CodiceReferto']."</button></form></td>";
					} else {
						echo "<td>Referto non disponibile</td>";
					}
					echo "</tr>";
				}


			}

		?>

	</table>



</div>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>