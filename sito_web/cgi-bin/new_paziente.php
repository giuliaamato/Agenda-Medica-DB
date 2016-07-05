<?php
	
	session_start();

	include("db_config.php");


	if (!isset($_SESSION['username']) && !$_SESSION['logged_as']=='admin'){

		header("Location: index.html");
		die();

	}


  if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['gridRadios']) && isset($_POST['birthday']) && isset($_POST['email']) && isset($_POST['tel']) && isset($_POST['cNascita']) && isset($_POST['cResidenza']) && isset($_POST['username']) && isset($_POST['indirizzo']) && isset($_POST['esenzione'])){

    

    $nome = $_POST['nome'];
    $indirizzo = $_POST['indirizzo'];
    $cod_esenzione = $_POST['esenzione'];
    $cognome = $_POST['cognome'];
    $sesso = $_POST['gridRadios'];
    $data_nascita = $_POST['birthday'];
    $email = $_POST['email'];
    $telefono = $_POST['tel'];
    $citta_nascita = $_POST['cNascita'];
    $citta_residenza = $_POST['cResidenza'];
    
    $cf_nuovo_infermiere = $_POST['new_cf'];

    if (isset($cf_nuovo_infermiere)){

      // DA COMPLETARE
      $db_conn = new DBConfig();

      $r = $db_conn->db_query("SELECT CodiceASL FROM Informazioni WHERE Informazioni.CodiceFiscale='".$_SESSION['codice_fiscale']."'");

      $codice_asl = $r[0]['CodiceASL'];


      $db_conn->db_query("INSERT INTO Informazioni VALUES ('".$cf_nuovo_infermiere."','".$data_nascita."','".$nome."','".$cognome."','".$email."','".$sesso."',".$telefono.",'".$citta_residenza."','".$citta_nascita."','".$indirizzo."',".$codice_asl.")");
      $db_conn->db_query("INSERT INTO Paziente VALUES ('".$cf_nuovo_infermiere."','".$cod_esenzione."')");
       
       header("Location: indexadmin.php");

    }


  } else {
    if ($_SERVER['REQUEST_METHOD']=='POST'){
      echo "<div class='alert alert-danger'>
      <strong>ATTENZIONE!</strong> Alcuni campi non sono stati compilati
      </div>";
    }
  }



?>

<!doctype html>
<html>
<head>
    <title>Nuovo paziente</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    
</head>


<body>



<div class="container">

	<h1>Nuovo paziente</h1>

	<a class='btn btn-danger' href='indexadmin.php'>Torna al pannello di amministrazione</a>

	<br /><br />

	<form method='POST' action='#'>
		
		<div class="form-group row">
    		<label for="cf" class="col-sm-2 form-control-label">Codice Fiscale</label>
    		<div class="col-sm-10">
      		<input name='new_cf' class="form-control" id="cf" placeholder="XXXXXXXXXXXXX">
    		</div>
    	</div>

		<div class="form-group row">
    		<label for="Nome" class="col-sm-2 form-control-label">Nome</label>
    		<div class="col-sm-10">
      		<input name='nome' class="form-control" id="Nome" placeholder="Nome">
    		</div>
    	</div>
 		
    	<div class="form-group row">
    		<label for="Cognome" class="col-sm-2 form-control-label">Cognome</label>
    		<div class="col-sm-10">
      		<input name='cognome' class='form-control' id='Cognome' placeholder="Cognome" />
    		</div>
    	</div>
    	<div class="form-group row">
        <label for="esenzione" class="col-sm-2 form-control-label">Codice esenzione</label>
        <div class="col-sm-10">
          <input name='esenzione' class='form-control' id='esenzione' placeholder="Codice Esenzione" />
        </div>
      </div>

  		<div class="form-group row">
    		<label class="col-sm-2">Sesso</label>
    		<div class="col-sm-10">
      			<div class="radio">
        			<label>
          			<input type="radio" name="gridRadios" id="controllo" value="M" />
          			M
        			</label>
      			</div>
      			<div class="radio">
        			<label>
          			<input type="radio" name="gridRadios" id="visita" value="F" />
          			F
        			</label>
      			</div>
			</div>
  		</div>
      
    	<div class="form-group row">
        <label for="data-nascita" class="col-sm-2 form-control-label">Data di nascita</label>
        <div class="col-sm-10">
          <input name='birthday' class='form-control' id='data-nascita' placeholder="aaaa-mm-gg" />
        </div>
      </div>
      <div class="form-group row">
        <label for="email" class="col-sm-2 form-control-label">E-mail</label>
        <div class="col-sm-10">
          <input name='email' type='email' class='form-control' id='email' placeholder="E-mail" />
        </div>
      </div>
      <div class="form-group row">
        <label for="telefono" class="col-sm-2 form-control-label">Telefono</label>
        <div class="col-sm-10">
          <input name='tel' class='form-control' id='telefono' />
        </div>
      </div>
      <div class="form-group row">
        <label for="indir" class="col-sm-2 form-control-label">Indirizzo</label>
        <div class="col-sm-10">
          <input name='indirizzo' class='form-control' id='indir' placeholder="Indirizzo" />
        </div>
      </div>
      <div class="form-group row">
          <label for="CittaNascita" class="col-sm-2">Città di nascita</label>
          <div class="col-sm-10">
            <select name='cNascita' id="CittaNascita" class="form-control">
              <option>-</option>
              <?php 

                // ottieni gli infermieri disponibili
                $db_conn = new DBConfig();

                $rows = $db_conn->db_query("SELECT * FROM Citta");

                for ($i=0; $i < count($rows); $i++) { 
                  $c = $rows[$i];
                  echo "<option>".$c['Nome']."</option>";
                }

              ?>
            </select>
          </div>
      </div>
      <div class="form-group row">
          <label for="CittaResidenza" class="col-sm-2">Città di residenza</label>
          <div class="col-sm-10">
            <select name='cResidenza' id="CittaResidenza" class="form-control">
              <option>-</option>
              <?php 

                // ottieni gli infermieri disponibili
                $db_conn = new DBConfig();

                $rows = $db_conn->db_query("SELECT * FROM Citta WHERE Provincia=(SELECT Provincia FROM Citta WHERE Nome=(SELECT CittaSede FROM ASL WHERE ASL.Codice=(SELECT CodiceASL FROM Informazioni WHERE Informazioni.CodiceFiscale='".$_SESSION['codice_fiscale']."')))");

                for ($i=0; $i < count($rows); $i++) { 
                  $c = $rows[$i];
                  echo "<option>".$c['Nome']."</option>";
                }

              ?>
            </select>
          </div>
      </div>
      <br />
    
    	<button type="submit" class="btn btn-primary">Inserisci nuovo paziente</button>
    	
	</form>

  <br />


</div>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>
