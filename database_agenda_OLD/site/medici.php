<?php
require(dirname(__FILE__)."/lib/html_lib.php");
require(dirname(__FILE__)."/lib/var_common.php");
require(dirname(__FILE__)."/lib/db_lib.php");

$vars = new var_common();
$title = "Medici";

if(!isset($_GET[$vars->get_session_sid()])){
	header("Location: index.php");
	die();
}

session_name($vars->get_session_name($_GET[$vars->get_session_sid()]));
session_start();

if(!isset($_SESSION["admin_id"])){
	header("Location: index.php");
	die();
}

$html = new html_lib();
echo $html->header($vars->get_app_title()." - ".$title);

echo "\n<body>
<h1>".$vars->get_app_title()."</h1>";

if(isset($_POST["medico_modifica"])){
	$id=-1;
	$operazione = "";
	$db = new db_lib();
	$data_nascita = "";
	if(isset($_POST["medico_data_nascita_anno"])){
		$data_nascita = $_POST["medico_data_nascita_anno"];
		if(isset($_POST["medico_data_nascita_mese"])){
			$data_nascita.="-".$_POST["medico_data_nascita_mese"];
		}
		else{
			$data_nascita.="-01";
		}
		if(isset($_POST["medico_data_nascita_giorno"])){
			$data_nascita.="-".$_POST["medico_data_nascita_giorno"];
		}
		else{
			$data_nascita.="-01";
		}
	}
	//update
	if(isset($_POST["medico_id"])){
		$operazione ="aggiornato";
		$id=$_POST["medico_id"];
		$query='UPDATE utente SET
				nome= "'.trim($_POST["medico_nome"]).'",
				cognome= "'.trim($_POST["medico_cognome"]).'",
				sesso= "'.$_POST["medico_sesso"].'",
				domicilio_stato= "'.$_POST["medico_domicilio_stato"].'",
				domicilio_regione= "'.$_POST["medico_domicilio_regione"].'",
				domicilio_citta= "'.$_POST["medico_domicilio_citta"].'",
				domicilio_provincia= "'.$_POST["medico_domicilio_provincia"].'",
				domicilio_via= "'.$_POST["medico_domicilio_via"].'",
				domicilio_numero= "'.$_POST["medico_domicilio_numero"].'",
				data_nascita= "'.$data_nascita.'",
				telefono= "'.$_POST["medico_telefono"].'",
				email= "'.$_POST["medico_email"].'",
				note= "'.$_POST["medico_note"].'",
				password="'.trim($_POST["medico_password"]).' "
				WHERE utente_id='.$id;
		$res = $db->query($query);
		$query2='UPDATE medico SET
				specialita= "'.$_POST["medico_specialita"].'"
				WHERE medico_id='.$id;
		$res = $db->query($query2);
	}
	//new
	else{
		$operazione ="aggiunto";
		$query="SELECT utente_id FROM utente ORDER BY utente_id DESC LIMIT 1 ";
		$res = $db->query($query);
		$id = $res[0]["utente_id"]+1;

		$query='INSERT INTO utente(utente_id, nome, cognome, sesso,
				domicilio_stato, domicilio_regione, domicilio_provincia, domicilio_citta,
				domicilio_via, domicilio_numero, data_nascita,
				telefono, email, note, password) VALUES ('.$id.',
				"'.trim($_POST["medico_nome"]).'",
				"'.trim($_POST["medico_cognome"]).'",
				"'.$_POST["medico_sesso"].'",
				"'.$_POST["medico_domicilio_stato"].'",
				"'.$_POST["medico_domicilio_regione"].'",
				"'.$_POST["medico_domicilio_provincia"].'",
				"'.$_POST["medico_domicilio_citta"].'",
				"'.$_POST["medico_domicilio_via"].'",
				"'.$_POST["medico_domicilio_numero"].'",
				"'.$data_nascita.'",
				"'.$_POST["medico_telefono"].'",
				"'.$_POST["medico_email"].'",
				"'.$_POST["medico_note"].'",
				"'.trim($_POST["medico_password"]).'")';
		$res = $db->query($query);

		$query='INSERT INTO medico(medico_id, specialita) VALUES ('.$id.',
				"'.$_POST["medico_specialita"].'")';
		$res = $db->query($query);
	}
	echo '<h3>Medico '.$_POST["medico_nome"].' '.$_POST["medico_cognome"].' ('.$id.') '.$operazione.'</h3>';
}

if((isset($_POST["visualizza"]) && isset($_POST["medico_view"])) || isset($_POST["nuovo_medico"])){
	$res = null;
	if(isset($_POST["medico_view"])){
		$db = new db_lib();
		$res = $db->query("select * from utente JOIN medico ON utente_id = medico_id WHERE utente_id=".$_POST["medico_view"]);
	}
	echo '<table id="nav">
			<tr>
				<td><a href="medici.php?'.$vars->get_session_sid().'='.$_GET[$vars->get_session_sid()].'">
						<img src="img/indietro.png" height="48px" alt="Indietro"/>
					</a><br>Indietro</td>
				<td><a href=".">
						<img src="img/reset.png" height="48px" alt="Reset"/>
					</a><br>Chiudi sessione di lavoro</td>
			</tr></table>';
	echo '<div id="dati_paziente">
			<h2>Dati medico:</h2>';
	echo '<form method="POST" action="medici.php?'.$vars->get_session_sid().'='.$_GET[$vars->get_session_sid()].'">';
	echo '<table border="1">
		<tr><td><b>Nome</b></td><td><input type="text" name="medico_nome" value="'.$res[0]["nome"].'"/></td></tr>
		<tr><td><b>Cognome</b></td><td><input type="text" name="medico_cognome" value="'.$res[0]["cognome"].'"/></td></tr>
		<tr><td><b>Sesso</b></td><td><input type="text" name="medico_sesso" value="'.$res[0]["sesso"].'"/></td></tr>
		<tr><td><b>Telefono</b></td><td><input type="text" name="medico_telefono" value="'.$res[0]["telefono"].'"/></td></tr>
		<tr><td><b>Email</b></td><td><input type="text" name="medico_email" value="'.$res[0]["email"].'"/></td></tr>
		<tr><td><b>Specialita\'</b></td><td><input type="text" name="medico_specialita" value="'.$res[0]["specialita"].'"/></td></tr>
		<tr><td><b>Data nascita</b></td><td>
				<i>Anno:</i><input type="text" name="medico_data_nascita_anno" value="'.date("Y", strtotime($res[0]["data_nascita"])).'"/><br>
				<i>Mese:</i><input type="text" name="medico_data_nascita_mese" value="'.date("m", strtotime($res[0]["data_nascita"])).'"/><br>
				<i>Giorno:</i><input type="text" name="medico_data_nascita_giorno" value="'.date("d", strtotime($res[0]["data_nascita"])).'"/></td></tr>
		<tr><td><b>Domicilio</b></td><td>
				<i>Stato:</i><input type="text" name="medico_domicilio_stato" value="'.$res[0]["domicilio_stato"].'"/><br>
				<i>Regione:</i><input type="text" name="medico_domicilio_regione" value="'.$res[0]["domicilio_regione"].'"/><br>
				<i>Provincia:</i><input type="text" name="medico_domicilio_provincia" value="'.$res[0]["domicilio_provincia"].'"/><br>
				<i>Città:</i><input type="text" name="medico_domicilio_citta" value="'.$res[0]["domicilio_citta"].'"/><br>
				<i>Via:</i><input type="text" name="medico_domicilio_via" value="'.$res[0]["domicilio_via"].'"/><br>
				<i>NC:</i><input type="text" name="medico_domicilio_numero" value="'.$res[0]["domicilio_numero"].'"/></td></tr>
		<tr><td><b>Password</b></td><td><input type="text" name="medico_password" value="'.$res[0]["password"].'"/></td></tr>
	</table>
	<dl>
		<dt><b>Note:</b></dt><dd><textarea name="medico_note" rows="5" cols="40">'.$res[0]["note"].'</textarea></dd>
	</dl>';
	if(isset($_POST["medico_view"])){
		echo '<input type="hidden" name="medico_id" value="'.$_POST["medico_view"].'"/>';
	}
	echo '<input type="submit" name="medico_modifica" value="Aggiungi / Modifica medico"/>
	</form>
	<div>';
}
else{
	echo '<table id="nav">
			<tr>
				<td><a href="index.php?'.$vars->get_session_sid().'='.$_GET[$vars->get_session_sid()].'">
						<img src="img/indietro.png" height="48px" alt="Indietro"/>
					</a><br>Indietro</td>
				<td><form method="POST" action="medici.php?'.$vars->get_session_sid().'='.$_GET[$vars->get_session_sid()].'">
					<input name="nuovo_medico" value="true" type="hidden" />
					<input name="nuovo_medico" value="Aggiungi Medico" type="image" src="img/doctorAdd.png" alt="invia il modulo" title="Aggiungi nuovo medico"  height="48px"/>
					</form>
					Aggiungi medico</td>
				<td><input type="image" src="img/print.png" height="48px" onClick="window.print()" value="Print This Page" title="Stampa pagina corrente" />Stampa pagina</td>
				<td><a href=".">
						<img src="img/reset.png" height="48px" alt="Reset"/>
					</a><br>Chiudi sessione di lavoro</td>
			</tr></table>';
	$db = new db_lib();
	$res = $db->query("select * from utente JOIN medico ON utente_id = medico_id");
	echo '
	<form method="POST" action="medici.php?'.$vars->get_session_sid().'='.$_GET[$vars->get_session_sid()].'">
	Medici registrati:<br>';
	echo '<table style="border:0px">';
	for($i=0; $i<count($res); ++$i){
		echo '<tr>
			<td><input type="radio" name="medico_view" value="'.$res[$i]["utente_id"].'" /></td>
			<td>'.$res[$i]["nome"].'</td>
			<td>'.$res[$i]["cognome"].'</td>
			<td>'.$res[$i]["telefono"].'</td>
			<td>'.$res[$i]["specialita"].'</td>
			</tr>';
	}
	echo '
	</table>
	   	<input type="submit" name="visualizza" value="Visualizza">
	</form>';
}
?>
