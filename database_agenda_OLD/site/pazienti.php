<?php
require(dirname(__FILE__)."/lib/html_lib.php");
require(dirname(__FILE__)."/lib/var_common.php");
require(dirname(__FILE__)."/lib/db_lib.php");

$vars = new var_common();
$title = "Pazienti registrati";

if(!isset($_GET[$vars->get_session_sid()])){
	header("Location: index.php");
	die();
}
session_name($vars->get_session_name($_GET[$vars->get_session_sid()]));
session_start();

$html = new html_lib();
echo $html->header($vars->get_app_title()." - ".$title);

echo "\n<body>
<h1>".$vars->get_app_title()."</h1>";


if(isset($_POST["paziente_modifica"])){
	$id=-1;
	$operazione = "";
	$db = new db_lib();
	$data_nascita = "";
	if(isset($_POST["paziente_data_nascita_anno"])){
		$data_nascita = $_POST["paziente_data_nascita_anno"];
		if(isset($_POST["paziente_data_nascita_mese"])){
			$data_nascita.="-".$_POST["paziente_data_nascita_mese"];
		}
		else{
			$data_nascita.="-01";
		}
		if(isset($_POST["paziente_data_nascita_giorno"])){
			$data_nascita.="-".$_POST["paziente_data_nascita_giorno"];
		}
		else{
			$data_nascita.="-01";
		}
	}
	//update
	if(isset($_POST["paziente_id"])){
		$operazione ="aggiornato";
		$id=$_POST["paziente_id"];
		$query='UPDATE utente SET 
				nome= "'.$_POST["paziente_nome"].'",
				cognome= "'.$_POST["paziente_cognome"].'",
				sesso= "'.$_POST["paziente_sesso"].'",
				domicilio_stato= "'.$_POST["paziente_domicilio_stato"].'",
				domicilio_regione= "'.$_POST["paziente_domicilio_regione"].'",
				domicilio_citta= "'.$_POST["paziente_domicilio_citta"].'",
				domicilio_provincia= "'.$_POST["paziente_domicilio_provincia"].'",
				domicilio_via= "'.$_POST["paziente_domicilio_via"].'",
				domicilio_numero= "'.$_POST["paziente_domicilio_numero"].'",
				data_nascita= "'.$data_nascita.'",
				telefono= "'.$_POST["paziente_telefono"].'",
				email= "'.$_POST["paziente_email"].'",
				note= "'.$_POST["paziente_note"].'"
				WHERE utente_id='.$id;
		$res = $db->query($query);
		$query='UPDATE paziente SET 
				nascita_stato= "'.$_POST["paziente_nascita_stato"].'",
				nascita_regione= "'.$_POST["paziente_nascita_regione"].'",
				nascita_citta= "'.$_POST["paziente_nascita_citta"].'",
				nascita_via= "'.$_POST["paziente_nascita_via"].'",
				nascita_numero= "'.$_POST["paziente_nascita_numero"].'",
				nascita_telefono= "'.$_POST["paziente_nascita_telefono"].'",
				tessera_sanitaria= "'.$_POST["paziente_tessera_sanitaria"].'",
				ENI="'.$_POST["paziente_eni"].'"
				WHERE paziente_id='.$id;
		$res = $db->query($query);
	}
	//new
	else{
		$operazione ="aggiunto";
		$query="SELECT utente_id FROM utente ORDER BY utente_id DESC LIMIT 1 ";
		$res = $db->query($query);
		$id = $res[0]["utente_id"]+1;
		
		$query='INSERT INTO utente(utente_id, nome, cognome, sesso, 
				domicilio_stato, domicilio_regione, domicilio_citta, domicilio_provincia,
				domicilio_via, domicilio_numero, data_nascita, 
				telefono, email, note) VALUES ('.$id.',
				"'.$_POST["paziente_nome"].'",
				"'.$_POST["paziente_cognome"].'",
				"'.$_POST["paziente_sesso"].'",
				"'.$_POST["paziente_domicilio_stato"].'",
				"'.$_POST["paziente_domicilio_regione"].'",
				"'.$_POST["paziente_domicilio_citta"].'",
				"'.$_POST["paziente_domicilio_provincia"].'",
				"'.$_POST["paziente_domicilio_via"].'",
				"'.$_POST["paziente_domicilio_numero"].'",
				"'.$data_nascita.'",
				"'.$_POST["paziente_telefono"].'",
				"'.$_POST["paziente_email"].'",
				"'.$_POST["paziente_note"].'")';
		$res = $db->query($query);
		
		$query='INSERT INTO paziente(paziente_id, nascita_stato, 
					nascita_regione, nascita_citta, nascita_via,
					nascita_numero, nascita_telefono, 
					tessera_sanitaria, ENI) VALUES ('.$id.',
				"'.$_POST["paziente_nascita_stato"].'",
				"'.$_POST["paziente_nascita_regione"].'",
				"'.$_POST["paziente_nascita_citta"].'",
				"'.$_POST["paziente_nascita_via"].'",
				"'.$_POST["paziente_nascita_numero"].'",
				"'.$_POST["paziente_nascita_telefono"].'",
				"'.$_POST["paziente_tessera_sanitaria"].'",
				"'.$_POST["paziente_eni"].'")';
		$res = $db->query($query);
	}
	echo '<h3>Paziente '.$_POST["paziente_nome"].' '.$_POST["paziente_cognome"].' ('.$id.') '.$operazione.'</h3>';
}



if((isset($_POST["visualizza"]) && isset($_POST["paziente_view"])) || isset($_POST["nuovo_paziente"])){
	$res = null;
	$visita_medica_nav = "";
	if(isset($_POST["paziente_view"])){
		$visita_medica_nav = '<td><form method="POST" action="visita_medica.php?'.$vars->get_session_sid().'='.$_GET[$vars->get_session_sid()].'">
						<input type="hidden" name="paziente_id" value="'.$_POST["paziente_view"].'"/>
						<input name="visualizza" value="Nuova visita medica" type="image" src="img/visita.png" alt="invia il modulo" title="Aggiungi una visita medica all\'utente attuale"  height="48px"/>
					</form>
					Nuova visita medica</td>
					<td><input type="image" src="img/print.png" height="48px" onClick="window.print()" value="Print This Page" title="Stampa pagina corrente" />Stampa pagina</td>			
					';
		$db = new db_lib();
		$res = $db->query("select * from utente JOIN paziente ON utente_id = paziente_id WHERE utente_id=".$_POST["paziente_view"]);
	}
	echo '<table id="nav">
			<tr>
				<td><a href="pazienti.php?'.$vars->get_session_sid().'='.$_GET[$vars->get_session_sid()].'">
						<img src="img/indietro.png" height="48px" alt="Indietro"/>
					</a><br>Indietro</td>'.$visita_medica_nav.'<td><a href=".">
						<img src="img/reset.png" height="48px" alt="Reset"/>
					</a><br>Chiudi sessione di lavoro</td>
			</tr></table>';
	
	echo '<div id="dati_paziente">
			<h2>Dati paziente:</h2>';
	echo '<form method="POST" action="pazienti.php?'.$vars->get_session_sid().'='.$_GET[$vars->get_session_sid()].'">';
	echo '<table >
		<tr><td><b>Nome</b></td><td><input type="text" name="paziente_nome" value="'.$res[0]["nome"].'"/></td></tr>
		<tr><td><b>Cognome</b></td><td><input type="text" name="paziente_cognome" value="'.$res[0]["cognome"].'"/></td></tr>
		<tr><td><b>Sesso</b></td><td><input type="text" name="paziente_sesso" value="'.$res[0]["sesso"].'"/></td></tr>
		<tr><td><b>Tessera sanitaria</b></td><td><input type="text" name="paziente_tessera_sanitaria" value="'.$res[0]["tessera_sanitaria"].'"/></td></tr>
		<tr><td><b>ENI</b></td><td><input type="text" name="paziente_eni" value="'.$res[0]["ENI"].'"/></td></tr>
		<tr><td><b>Telefono</b></td><td><input type="text" name="paziente_telefono" value="'.$res[0]["telefono"].'"/></td></tr>
		<tr><td><b>Email</b></td><td><input type="text" name="paziente_email" value="'.$res[0]["email"].'"/></td></tr>
		<tr><td><b>Data nascita</b></td><td>
				<i>Anno:</i><input type="text" name="paziente_data_nascita_anno" value="'.date("Y", strtotime($res[0]["data_nascita"])).'"/><br>
				<i>Mese:</i><input type="text" name="paziente_data_nascita_mese" value="'.date("m", strtotime($res[0]["data_nascita"])).'"/><br>
				<i>Giorno:</i><input type="text" name="paziente_data_nascita_giorno" value="'.date("d", strtotime($res[0]["data_nascita"])).'"/></td></tr>
		<tr><td><b>Originario</b></td><td>
				<i>Stato:</i><input type="text" name="paziente_nascita_stato" value="'.$res[0]["nascita_stato"].'"/><br>
				<!--<i>Regione:</i><input type="text" name="paziente_nascita_regione" value="'.$res[0]["nascita_regione"].'"/><br>
				<i>Città:</i><input type="text" name="paziente_nascita_citta" value="'.$res[0]["nascita_citta"].'"/><br>
				<i>Via:</i><input type="text" name="paziente_nascita_via" value="'.$res[0]["nascita_via"].'"/><br>
				<i>NC:</i><input type="text" name="paziente_nascita_numero" value="'.$res[0]["nascita_numero"].'"/><br>
				<i>Telefono:</i><input type="text" name="paziente_nascita_telefono" value="'.$res[0]["nascita_telefono"].'"/></td>-->
		</tr>
		<tr><td><b>Domicilio</b></td><td>
				<i>Stato:</i><input type="text" name="paziente_domicilio_stato" value="'.$res[0]["domicilio_stato"].'"/><br>
				<i>Regione:</i><input type="text" name="paziente_domicilio_regione" value="'.$res[0]["domicilio_regione"].'"/><br>
				<i>Provincia:</i><input type="text" name="paziente_domicilio_provincia" value="'.$res[0]["domicilio_provincia"].'"/><br>
				<i>Città:</i><input type="text" name="paziente_domicilio_citta" value="'.$res[0]["domicilio_citta"].'"/><br>
				<i>Via:</i><input type="text" name="paziente_domicilio_via" value="'.$res[0]["domicilio_via"].'"/><br>
				<i>NC:</i><input type="text" name="paziente_domicilio_numero" value="'.$res[0]["domicilio_numero"].'"/></td></tr>
		<tr><td><b>Note:</b></td>
			<td><textarea name="paziente_note" rows="5" cols="40">'.$res[0]["note"].'</textarea></td>
		</tr>
	</table>';
	$tipo_modifica="Aggiungi";
	if(isset($_POST["paziente_view"])){
		echo '<input type="hidden" name="paziente_id" value="'.$_POST["paziente_view"].'"/>';
		$tipo_modifica = "Modifica";
	}
	
	echo '<input type="submit" name="paziente_modifica" value="'.$tipo_modifica.' paziente"/>
	</form>
	<div>';

	if(isset($_POST["paziente_view"])){
	$res = $db->query("select * from visita_medica WHERE paziente_id=".$_POST["paziente_view"]);
	
	echo '<div id="dati_paziente">
			<h2>Visite effettuate:</h2>';
	for($i=0; $i<count($res); ++$i){
		$res_md = $db->query("select * from utente JOIN medico ON utente_id = medico_id WHERE medico_id=".$res[$i]["medico_id"]);
		if($i > 0){
			echo "<br>";
		}
		echo "<i>".date("d/m/Y H:i", strtotime($res[$i]["data"]))."</i>";
		echo '	
			<table border="0">
				<tr><td><b>Medico:</b></td><td>'.$res_md[0]["nome"].' '.$res_md[0]["cognome"].'</td></tr>
				<tr><td><b>Tipo:</b></td><td>'.$res[$i]["tipo"].'</td></tr>
				<tr><td><b>Motivazione:</b></td><td>'.$res[$i]["motivazione"].'</td></tr>
				<tr><td><b>Esame clinico:</b></td><td>'.$res[$i]["esame_clinico"].'</td></tr>
				<tr><td><b>Diagnosi:</b></td><td>'.$res[$i]["diagnosi"].'</td></tr>
				<tr><td><b>Richiesta esami:</b></td><td>'.$res[$i]["richiesta_esami"].'</td></tr>
				<tr><td><b>Terapia prescritta:</b></td><td>'.$res[$i]["terapia_prescritta"].'</td></tr>
				<tr><td><b>Farmaci attualmente assunti:</b></td><td>'.$res[$i]["farmaci_attuali_assunzione"].'</td></tr>
				<tr><td><b>Farmaci prescritti con ricetta:</b></td><td>'.$res[$i]["farmaci_prescritti_ricetta"].'</td></tr>
				<tr><td><b>Farmaci consegnati:</b></td><td>'.$res[$i]["farmaci_consegnati"].'</td></tr>
				<tr><td><b>Data incontro successivo:</b></td><td>'.$res[$i]["data_ventura"].'</td></tr>
			</table>';
	}
	echo '</div>';
	}
}
else{
	echo '<table id="nav">
			<tr>
				<td><a href="index.php?'.$vars->get_session_sid().'='.$_GET[$vars->get_session_sid()].'">
						<img src="img/indietro.png" height="48px" alt="Indietro"/>
					</a><br>Indietro</td>
				<td><form method="POST" action="pazienti.php?'.$vars->get_session_sid().'='.$_GET[$vars->get_session_sid()].'">
					<input name="nuovo_paziente" value="true" type="hidden" />
					<input name="nuovo_paziente" value="Aggiungi Paziente" type="image" src="img/userAdd.png" alt="invia il modulo" title="Aggiungi nuovo paziente"  height="48px"/>
					</form>
					Aggiungi paziente</td>
				<td><a href=".">
						<img src="img/reset.png" height="48px" alt="Reset"/>
					</a><br>Chiudi sessione di lavoro</td>
			</tr></table>';
	
	$db = new db_lib();
	$query_string="select * from utente JOIN paziente ON utente_id = paziente_id";
	if((isset($_POST["paziente_view_by_name"]) && strlen($_POST["paziente_view_by_name"])>0) || 
			(isset($_POST["paziente_view_by_cognome"]) && strlen($_POST["paziente_view_by_cognome"])>0) || 
			(isset($_POST["paziente_view_by_eni"]) && strlen($_POST["paziente_view_by_eni"])>0) || 
			(isset($_POST["paziente_view_by_tes_san"])) && strlen($_POST["paziente_view_by_tes_san"])>0){
		$query_string .= " WHERE ";
		$i = 0;
		if(isset($_POST["paziente_view_by_name"]) && strlen($_POST["paziente_view_by_name"])>0){
			$query_string .= "nome = '".$_POST["paziente_view_by_name"]."'";
			++$i;
		}
		if(isset($_POST["paziente_view_by_cognome"]) && strlen($_POST["paziente_view_by_cognome"])>0){
			if($i > 0){
				$query_string .= " AND ";
			}
			$query_string .= "cognome = '".$_POST["paziente_view_by_cognome"]."'";
			++$i;
		}
		if(isset($_POST["paziente_view_by_eni"]) && strlen($_POST["paziente_view_by_eni"])>0){
			if($i > 0){
				$query_string .= " AND ";
			}
			$query_string .= "ENI = '".$_POST["paziente_view_by_eni"]."'";
			++$i;
		}
		if(isset($_POST["paziente_view_by_tes_san"]) && strlen($_POST["paziente_view_by_tes_san"])>0){
			if($i > 0){
				$query_string .= " AND ";
			}
			$query_string .= "tessera_sanitaria = '".$_POST["paziente_view_by_tes_san"]."'";
			++$i;
		}
		
	}
	$res = $db->query($query_string);
	
	echo '
	<form method="POST" action="pazienti.php?'.$vars->get_session_sid().'='.$_GET[$vars->get_session_sid()].'">
	Cerca paziente: 
	<table  style="border:0px">
		<tr>
			<td>Nome: <input type="text" name="paziente_view_by_name"></input></td>
			<td>Cognome: <input type="text" name="paziente_view_by_cognome"></input></td>
		</tr>
		<tr>
			<td>ENI: <input type="text" name="paziente_view_by_eni"></input></td>
			<td>Tessera sanitaria: <input type="text" name="paziente_view_by_tes_san"></input></td>
		</tr>
	</table>
	<input type="submit" name="visualizza" value="Cerca paziente"><br/><br/>
	Pazienti registrati:<br>
	<table  style="border:0px">
		<tr>
		    <th></th>
		    <th>Nome</th>
		    <th>Cognome</th>
			<th>Tessera sanitaria</th>
			<th>ENI</th>
		  </tr>';
		for($i=0; $i<count($res); ++$i){
			echo '<tr>				
					<td><input type="radio" name="paziente_view" value="'.$res[$i]["utente_id"].'"></input></td>
					<td>'.$res[$i]["nome"].'</td>
					<td>'.$res[$i]["cognome"].'</td>
					<td>'.$res[$i]["tessera_sanitaria"].'</td>
					<td>'.$res[$i]["ENI"].'</td></tr>';
		}
		echo '<br>
		</table>
	   	<input type="submit" name="visualizza" value="Visualizza paziente">
	</form>';
}		
		
		echo "</body>\n</html>";

?>
