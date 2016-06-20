<?php
	
	session_start();
	include ('db_config.php');
	include ('delete_functions.php');

	

	if ($_SERVER['REQUEST_METHOD']='POST' && isset($_POST['logout-btn'])){

			session_unset();
			session_destroy();
			header("Location: loginCUP.php");
			die();

	}


	

	if (!$_SESSION['logged_as'] == 'cup' && !isset($_SESSION['cod_asl'])){

		header("Location: loginCUP.php");
		die();

	}



?>

<!doctype html>
<html>
<head>
    <title>Indice CUP</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"/>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>

    
</head>


<body>
<nav class="navbar navbar-inverse">
  <div class="navbar-header">
    <a class="navbar-brand" href="#">Centro Unico Prenotazioni</a>
  </div>
  
  <form method='POST' action='#'><input type='hidden' name='logout-btn' value='logout'/><button type="submit" class="btn btn-default navbar-btn">Logout</button></form>
</nav>

<div class="container">
<?php
	
	$db_conn = new DBConfig();
	$row = $db_conn->db_query("SELECT ASL.CittaSede FROM ASL WHERE ASL.Codice=".$_SESSION['cod_asl'].";");
	
	if (count($row) == 1){

		$asl = $row[0];

		echo "<h1 class='text-center'>Centro Unico Prenotazioni della ASL di ".$asl['CittaSede']."</h1>";

	}
?>

<form method='POST' action='#'>
		<div class="form-group row">
      		<label for="Spec" class="col-sm-2">Specializzazione</label>
      		<div class="col-sm-10">
      			<?php echo"<select id='Spec' class='form-control' onchange='mostraDottori(this.value,".$_SESSION['cod_asl'].")'>";

      					echo "<option>-- Seleziona una specializzazione --</option>";
        			

        				$specs = $db_conn->db_query("SELECT DISTINCT Dottore.Specializzazione FROM Dottore JOIN Informazioni ON Dottore.CodiceFiscale=Informazioni.CodiceFiscale WHERE Informazioni.CodiceASL=".$_SESSION['cod_asl']);

        				for ($i=0; $i < count($specs) ; $i++) { 
        					$s = $specs[$i];
        					echo "<option>".$s['Specializzazione']."</option>";
        				}


        			?>
      			</select>
      		</div>
    	</div>
    	<div class="form-group row">
      		<label for="dottore" class="col-sm-2">Dottore</label>
      		<div class="col-sm-10">
      			<select id="dottore" class="form-control"></select>
      		</div>
    	</div>


		<div class="form-group row">
    		<label for="CFPaziente" class="col-sm-2 form-control-label">CF Paziente</label>
    		<div class="col-sm-10">
      		<input class="form-control" id="CFPaziente" placeholder="Codice Fiscale Paziente">
    		</div>
    	</div>
 		
    	<div class="form-group row">
      		<label for="Infermiere" class="col-sm-2">Infermiere</label>
      		<div class="col-sm-10">
      			<select id="Infermiere" class="form-control">
        			<?php 

        				// ottieni gli infermieri disponibili
        				$db_conn = new DBConfig();

        				$rows = $db_conn->db_query("SELECT Informazioni.Nome,Informazioni.Cognome,Infermiere.CodiceFiscale, Infermiere.Tirocinante FROM Infermiere JOIN Informazioni ON Infermiere.CodiceFiscale=Informazioni.CodiceFiscale WHERE Informazioni.CodiceASL=".$_SESSION['cod_asl']);

        				


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


<script type="text/javascript">
	
function mostraDottori(specializzazione,cod){

      var xhttp = new XMLHttpRequest();

     	xhttp.onreadystatechange = function(){

        if (xhttp.readyState == 4 && xhttp.status == 200){
          document.getElementById('dottore').innerHTML = xhttp.responseText;
        }
      };
      xhttp.open("GET",'get_dottori.php?s='+specializzazione+'&asl='+cod);
      xhttp.send();

  }

  



</script>

</body>
</html>
