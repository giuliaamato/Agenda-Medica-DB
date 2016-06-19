<?php
	
	session_start();

	include("db_config.php");


	if (!isset($_SESSION['username']) && !$_SESSION['logged_as']=='dottore'){

		header("Location: logindottore.php");
		die();

	}



?>

<!doctype html>
<html>
<head>
    <title>Nuova Visita</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    
</head>


<body>



<div class="container">

	<h1>Nuova Visita Medica</h1>

	<a class='btn btn-danger' href='indexdottore.php'>Torna all'agenda</a>

	<br /><br />

	<form method='POST' action='#'>

		<div class="form-group row">
    		<label for="CFPaziente" class="col-sm-2 form-control-label">CF Paziente</label>
    		<div class="col-sm-10">
      		<input class="form-control" id="CFPaziente" placeholder="Codice Fiscale Paziente">
    		</div>
    	</div>
 		<fieldset disabled>
    	<div class="form-group row">
    		<label for="CFDottore" class="col-sm-2 form-control-label">CF Dottore</label>
    		<div class="col-sm-10">
      		<?php echo "<input class='form-control' id='CFDottore' value='".$_SESSION['codice_fiscale']."'>"; ?>
    		</div>
    	</div>
    	</fieldset>
    	<div class="form-group row">
      		<label for="Infermiere" class="col-sm-2">Infermiere</label>
      		<div class="col-sm-10">
      			<select id="Infermiere" class="form-control">
        			<?php 

        				// ottieni gli infermieri disponibili
        				$db_conn = new DBConfig();

        				$rows = $db_conn->db_query("SELECT Informazioni.Nome,Informazioni.Cognome,Infermiere.CodiceFiscale, Infermiere.Tirocinante FROM Infermiere JOIN Informazioni ON Infermiere.CodiceFiscale=Informazioni.CodiceFiscale WHERE Informazioni.CodiceASL=(SELECT CodiceASL FROM Informazioni WHERE CodiceFiscale='".$_SESSION['codice_fiscale']."')");

        				


        				if (count($rows) > 0){
							
							for ($i=0; $i < count($rows); $i++) { 
        						
        						$infermiere = $rows[$i];

                    if ($infermiere['Tirocinante'] == 0){
                      $t = "Non tirocinante";
                    } else {
                      $t = "Tirocinante";
                    }

        						echo "<option>".$infermiere['CodiceFiscale']." - ".$infermiere['Nome']." ".$infermiere['Cognome']." - ".$t."</option>";


        					}


        				}





        			?>
      			</select>
      		</div>
    	</div>
  		<div class="form-group row">
    		<label class="col-sm-2">Tipo di visita</label>
    		<div class="col-sm-10">
      			<div class="radio">
        			<label>
          			<input type="radio" name="gridRadios" id="controllo" value="option1" />
          			Controllo
        			</label>
      			</div>
      			<div class="radio">
        			<label>
          			<input type="radio" name="gridRadios" id="visita" value="option2" />
          			Visita
        			</label>
      			</div>
			</div>
  		</div>
 
 		<div class="form-group row">
      		<label for="disabledSelect" class="col-sm-2">Ambulatorio</label>
      		<div class="col-sm-10">
      			<select id="disabledSelect" class="form-control">
        			<?php 

        				// ottieni gli ambulatori disponibili


        						echo "<option>$nome_ambulatorio</option>"; 





        			?>
      			</select>
      		</div>
    	</div>
    	<div class="form-group row">
      		<label for="disabledSelect" class="col-sm-2">Data</label>
      		<div class="col-sm-10">
      			<select id="disabledSelect" class="form-control">
        			<?php 

        				// ottieni le date disponbili


        						echo "<option>$nome_ambulatorio</option>"; 





        			?>
      			</select>
      		</div>
    	</div>

    	<button type="submit" class="btn btn-primary">Inserisci nuova visita</button>
    	
	</form>



</div>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>
