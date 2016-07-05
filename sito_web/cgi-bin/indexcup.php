<?php
	
	session_start();
	include ('db_config.php');
	include ('delete_functions.php');

	

	if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['logout-btn'])){

			session_unset();
			session_destroy();
			header("Location: loginCUP.php");
			die();

	}


	

	if (!$_SESSION['logged_as'] == 'cup' && !isset($_SESSION['cod_asl'])){

		header("Location: loginCUP.php");
		die();

	}

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dottore']) && isset($_POST['paziente']) && isset($_POST['infermiere']) && isset($_POST['visita']) && isset($_POST['ora_visita']) && isset($_POST['data']) && isset($_POST['ambulatorio'])){

	
    $data = $_POST["data"]." ".$_POST["ora_visita"];
    $infermiere = explode(" ",$_POST['infermiere'])[0];
    $paziente = explode(" ",$_POST['paziente'])[0];
    $dottore= explode(" ",$_POST['dottore'])[0];
    
    $db_insert = new DBConfig();

    $db_insert->db_query("INSERT INTO VisitaMedica(Data,NomeAmbulatorio,TipoVisita,TipoPrenotazione,Priorita,CFDottore,CFInfermiere,CFPaziente,CodiceReferto) VALUES ('".$data."','".$_POST['ambulatorio']."',".$_POST['visita'].",0,'".$_POST['priorita']."','".$dottore."','".$infermiere."','".$paziente."',NULL)");

   
	
 }


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
      		<label for="dottore" class="col-sm-2">Dottore</label>
      		<div class="col-sm-10">
      			<select name="dottore" id="dottore" class="form-control" onchange='get_orari(this.value)' >
           
              <option>-</option>

              <?php 

                $dottori = $db_conn->db_query("SELECT Dottore.Specializzazione, Dottore.CodiceFiscale, Informazioni.Nome,Informazioni.Cognome FROM Dottore JOIN Informazioni ON Dottore.CodiceFiscale=Informazioni.CodiceFiscale WHERE Informazioni.CodiceASL=".$_SESSION['cod_asl']);

                for ($i=0; $i < count($dottori) ; $i++) { 
                  $d = $dottori[$i];
                  echo "<option>".$d['CodiceFiscale']." - ".$d['Nome']." ".$d['Cognome']." - ".$d['Specializzazione']."</option>";
                }


              ?>


            </select>
      		</div>
    	</div>
      <div class="form-group row">
          <label for="ora_select" class="col-sm-2">Orari disponibili</label>
          <div class="col-sm-10">
            <select name='ora_visita' id="ora_select" class="form-control">
              
            </select>
          </div>
      </div>
<div class="form-group row">
          <label for="prio" class="col-sm-2">Priorita</label>
          <div class="col-sm-10">
            <select name='priorita' id="prio" class="form-control">
              <option>H</option>
	      <option>L</option>
            </select>
          </div>
      </div>

      <div class="form-group row">
          <label for="date" class="col-sm-2">Data</label>
          <div class="col-sm-10">
            <select name='data' id="date" class="form-control" onchange='get_ambulatori(this.value,ora_select.value,dottore.value)'>
              <?php 

                
                $days = get_all_days(date("m"),date("d"));

                echo "<option> - </option>";

                for ($i=0; $i < count($days); $i++) { 
                  echo "<option>".$days[$i]."</option>";
                }
                    
                if (count($days) < 15){
                  $nextmonth = date("m",mktime(0,0,0,date("m")+1,1,date("Y")));
                  $days_next_month = get_all_days($nextmonth,1);
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

		  <div class="form-group row">
    		<label for="paziente" class="col-sm-2 form-control-label">CF Paziente</label>
    		<div class="col-sm-10">
      		<input name='paziente' class="form-control" id="paziente" placeholder="Codice Fiscale Paziente">
    		</div>
    	</div>
      
 		
    	<div class="form-group row">
      		<label for="Infermiere" class="col-sm-2">Infermiere</label>
      		<div class="col-sm-10">
      			<select name='infermiere' id="Infermiere" class="form-control">
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


 
 		
    	

    	<button type="submit" class="btn btn-primary">Inserisci nuova visita</button>
    	
	</form>
</div>


<script type="text/javascript">

  function get_ambulatori(data,ora,cf){

      cf = cf.split(" ")[0];

      var xhttp = new XMLHttpRequest();

      xhttp.onreadystatechange = function(){

        if (xhttp.readyState == 4 && xhttp.status == 200){
          document.getElementById('ambulatorio').innerHTML = xhttp.responseText;
        }
      
      };
      
      xhttp.open("GET",'get_ambulatori_disponibili.php?s='+data+'&o='+ora+'&cf='+cf);
      xhttp.send();

  }

  function get_orari(dottore){

      dottore = dottore.split(" ")[0];

      var xhttp = new XMLHttpRequest();

      xhttp.onreadystatechange = function(){

        if (xhttp.readyState == 4 && xhttp.status == 200){
          document.getElementById('ora_select').innerHTML = xhttp.responseText;
        }
      };
      xhttp.open("GET",'get_orari.php?d='+dottore);
      xhttp.send();

  }



</script>

</body>
</html>
