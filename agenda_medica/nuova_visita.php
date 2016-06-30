<?php
	
	session_start();

	include("db_config.php");




	if (!isset($_SESSION['username']) && !$_SESSION['logged_as']=='dottore'){

		header("Location: logindottore.php");
		die();

	}

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dottore']) && isset($_POST['paziente']) && isset($_POST['infermiere']) && isset($_POST['visita']) && isset($_POST['ora_visita']) && isset($_POST['giorno']) && isset($_POST['ambulatorio'])){


    $data = $_POST["giorno"]." ".$_POST["ora_visita"];
    $infermiere = explode(" ",$_POST['infermiere'])[0];
    $paziente = explode(" ",$_POST['paziente'])[0];
    
    $db_insert = new DBConfig();

    $db_insert->db_query("INSERT INTO VisitaMedica(Data,NomeAmbulatorio,TipoVisita,TipoPrenotazione,Priorita,CFDottore,CFInfermiere,CFPaziente,CodiceReferto) VALUES ('".$data."','".$_POST['ambulatorio']."',".$_POST['visita'].",0,'".$_POST['priorita']."','".$_POST['dottore']."','".$infermiere."','".$paziente."',NULL)");

    header("Location: indexdottore.php");

  }

  setcookie("cf_dottore",$_SESSION['codice_fiscale'], time()+31536000);


  function get_all_days($month,$cur_day){

    $list = array();
    $year = 2016;
    
    
    for($d=$cur_day; $d<=31; $d++){
      $time=mktime(12, 0, 0, $month, $d, $year);          
      if (date('m', $time)==$month){       
        $list[]=date('Y-m-d', $time);
      }
    }

    return $list;

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

	<form method='POST' action='nuova_visita.php'>

		<div class="form-group row">
          <label for="paziente" class="col-sm-2">Paziente</label>
          <div class="col-sm-10">
            <select name='paziente' id="paziente" class="form-control">
              <?php 

                $db_conn = new DBConfig();

                $res = $db_conn->db_query("SELECT Informazioni.CodiceFiscale,Informazioni.Nome,Informazioni.Cognome FROM Paziente JOIN Informazioni ON Paziente.CodiceFiscale=Informazioni.CodiceFiscale WHERE Informazioni.CodiceASL=(SELECT CodiceASL FROM Informazioni WHERE CodiceFiscale='".$_SESSION['codice_fiscale']."')");


                for ($i=0; $i < count($res); $i++) { 
                  
                  $paziente = $res[$i];

                  echo "<option>".$paziente['CodiceFiscale']." - ".$paziente["Nome"]." ".$paziente['Cognome']."</option>";


                }


              ?>
            </select>
          </div>
      </div>
 		
    	<div class="form-group row">
    		<label for="CFDottore" class="col-sm-2 form-control-label">CF Dottore</label>
    		<div class="col-sm-10">
      		<?php echo "<input name='dottore' class='form-control' id='CFDottore' value='".$_SESSION['codice_fiscale']."' readonly />"; ?>
    		</div>
    	</div>
    	
    	<div class="form-group row">
      		<label for="Infermiere" class="col-sm-2">Infermiere</label>
      		<div class="col-sm-10">
      			<select name='infermiere' id="Infermiere" class="form-control">
        			<?php 

        				// ottieni gli infermieri disponibili
        				

        				$rows = $db_conn->db_query("SELECT Informazioni.Nome,Informazioni.Cognome,Infermiere.CodiceFiscale, Infermiere.Tirocinante FROM Infermiere JOIN Informazioni ON Infermiere.CodiceFiscale=Informazioni.CodiceFiscale WHERE Informazioni.CodiceASL=(SELECT CodiceASL FROM Informazioni WHERE CodiceFiscale='".$_SESSION['codice_fiscale']."')");

        				


        				if (count($rows) > 0){
							
							for ($i=0; $i < count($rows); $i++) { 
        						
        						$infermiere = $rows[$i];

                    $res = $db_conn->db_query("SELECT Conta_Visite('".$infermiere['CodiceFiscale']."') AS num_visite");

                    $numero_visite = $res[0]['num_visite'];

                    if (!isset($numero_visite)){
                      $numero_visite = 0;
                    }

                    if ($infermiere['Tirocinante'] == 0){
                      $t = "Non tirocinante";
                    } else {
                      $t = "Tirocinante";
                    }

        						echo "<option>".$infermiere['CodiceFiscale']." - ".$infermiere['Nome']." ".$infermiere['Cognome']." - ".$t." - ".$numero_visite." visite effettuate</option>";


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
          			<input type="radio" name="visita" id="controllo" value="0" />
          			Controllo
        			</label>
      			</div>
      			<div class="radio">
        			<label>
          			<input type="radio" name="visita" id="visita" value="1" />
          			Visita
        			</label>
      			</div>
			</div>
  		</div>
      <div class="form-group row">
          <label for="priorita" class="col-sm-2">Priorità</label>
          <div class="col-sm-10">
            <select name='priorita' id="prio" class="form-control">
              <option>L</option>
              <option>M</option>
              <option>H</option>
            </select>
          </div>
      </div>
     
      <div class="form-group row">
          <label for="ora_select" class="col-sm-2">Orari disponibili</label>
          <div class="col-sm-10">
            <select name='ora_visita' id="ora_select" class="form-control">
              <?php 

                $res1 = $db_conn->db_query("SELECT OraInizio('".$_SESSION['codice_fiscale']."') AS OraInizio");
                $res2 = $db_conn->db_query("SELECT OraFine('".$_SESSION['codice_fiscale']."') AS OraFine");



                $oraCorrente = new DateTime($res1[0]['OraInizio']);
                $oraFine = new DateTime($res2[0]['OraFine']) ;

                while ($oraFine > $oraCorrente){
                  echo "<option>".$oraCorrente->format('H:i:s')."</option>";
                  date_add($oraCorrente, date_interval_create_from_date_string('30 min'));
                }


              ?>
            </select>
          </div>
      </div>
      <div class="form-group row">
          <label for="date-select" class="col-sm-2">Giorni disponibili</label>
          <div class="col-sm-10">
            

            <select name='giorno' id='date-select' class='form-control' onchange='get_ambulatori(this.value,ora_select.value)'>
            <?php   

                // ottieni le date disponbili
                $days = get_all_days("06",date("d"));

                echo "<option> - </option>";

                for ($i=0; $i < count($days); $i++) { 
                  echo "<option>".$days[$i]."</option>";
                }
                    
                if (count($days) < 15){
                  $days_next_month = get_all_days("07",1);
                  for ($i=0; $i < count($days_next_month); $i++) { 
                  echo "<option>".$days_next_month[$i]."</option>";
                }

                }




              ?>
            </select>
          </div>
      </div>
 
 		<div class="form-group row">
      		<label for="ambulatorio" class="col-sm-2">Ambulatorio</label>
      		<div class="col-sm-10">
      			<select name='ambulatorio' id="ambulatorio" class="form-control">
        			
      			</select>
      		</div>
    	</div>
    	

    	<button type="submit" class="btn btn-primary">Inserisci nuova visita</button>
    	
	</form>



</div>
<script type="text/javascript">

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

  
function get_ambulatori(data,ora){

      var cf = getCookie("cf_dottore");

      var xhttp = new XMLHttpRequest();

      xhttp.onreadystatechange = function(){

        if (xhttp.readyState == 4 && xhttp.status == 200){
          document.getElementById('ambulatorio').innerHTML = xhttp.responseText;
        }
      
      };
      
      xhttp.open("GET",'get_ambulatori_disponibili.php?s='+data+'&o='+ora+'&cf='+cf);
      xhttp.send();

  }

  



</script>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>
