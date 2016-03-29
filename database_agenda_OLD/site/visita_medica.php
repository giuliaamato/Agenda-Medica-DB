<?php
require(dirname(__FILE__)."/lib/html_lib.php");
require(dirname(__FILE__)."/lib/var_common.php");
require(dirname(__FILE__)."/lib/db_lib.php");

$vars = new var_common();
$title = "Visita medica";

if(!isset($_GET[$vars->get_session_sid()])){
	header("Location: index.php");
	die();
}
session_name($vars->get_session_name($_GET[$vars->get_session_sid()]));
session_start();

$html = new html_lib();
echo $html->header($vars->get_app_title()." - ".$title);

if(isset($_POST["aggiungi_visita"])){
	//query per la visita
	$data_prox_visita= "";
	if(isset($_POST["visita_medica_data_ventura_anno"]) && isset($_POST["visita_medica_data_ventura_mese"]) && isset($_POST["visita_medica_data_ventura_giorno"]) && isset($_POST["visita_medica_data_ventura_ora"])){
		$data_prox_visita = $_POST["visita_medica_data_ventura_anno"]."-". $_POST["visita_medica_data_ventura_mese"]."-".$_POST["visita_medica_data_ventura_giorno"]."-".$_POST["visita_medica_data_ventura_ora"];
		if(!empty($_POST["visita_medica_data_ventura_minuti"])){
			$data_prox_visita.="-".$_POST["visita_medica_data_ventura_minuti"];
		}
		else{
			$data_prox_visita.="-00";
		}
	}
	$query = 'INSERT INTO `visita_medica`(
				`medico_id`, `paziente_id`, 
				`tipo`, `motivazione`, 
				`esame_clinico`, `diagnosi`, 
				`richiesta_esami`, `farmaci_attuali_assunzione`, 
				`terapia_prescritta`, `farmaci_consegnati`, 
				`farmaci_prescritti_ricetta`, `data_ventura`) VALUES (
			'.$_SESSION["medico_id"].',	'.$_POST["paziente_id"].',
			"'.$_POST["visita_medica_tipo"].'", "'.$_POST["visita_medica_motivazione"].'",
			"'.$_POST["visita_medica_esame_clinico"].'", "'.$_POST["visita_medica_diagnosi"].'",
			"'.$_POST["visita_richiesta_esami"].'", "'.$_POST["visita_farmaci_attuali_assunzione"].'",
			"'.$_POST["visita_richiesta_terapia_prescritta"].'", "'.$_POST["visita_richiesta_farmaci_prescritti"].'",
			"'.$_POST["visita_richiesta_farmaci_prescritti_ricetta"].'", "'.$data_prox_visita.'")';
	$db = new db_lib();
	$res = $db->query($query);
	echo "<b>Visita aggiunta, tra 5 secondi ritornerete alla pagina dei pazienti.</b>";

	header("Location: pazienti.php?".$vars->get_session_sid().'='.$_GET[$vars->get_session_sid()], true, 303);
}
else{

$id_paziente = "";
if(!isset($_POST["paziente_id"])){
	header("Location: pazienti.php?".$vars->get_session_sid().'='.$_GET[$vars->get_session_sid()]);
}

$id_paziente = $_POST["paziente_id"];
$db = new db_lib();
$res = $db->query("SELECT * FROM utente WHERE utente_id = ".$id_paziente);

echo '<div id="visita_medica">
			<h2>Visita medica per il paziente '.$res[0]["nome"]." ".$res[0]["cognome"].'</h2>';
echo '<table id="nav">
			<tr>
				<td><a href="pazienti.php?'.$vars->get_session_sid().'='.$_GET[$vars->get_session_sid()].'">
						<img src="img/indietro.png" height="48px" alt="Indietro"/>
					</a><br>Indietro</td>
				<td><a href=".">
						<img src="img/reset.png" height="48px" alt="Reset"/>
					</a><br>Chiudi sessione di lavoro</td>
			</tr></table>';
echo '<form method="POST" action="visita_medica.php?'.$vars->get_session_sid().'='.$_GET[$vars->get_session_sid()].'">';
/*
 * 		<tr><td><b>Data visita:</b></td><td>
				<i>Anno:</i><input type="text" name="visita_medica_anno" value="'.date("Y").'"/><br>
				<i>Mese:</i><input type="text" name="visita_medica_mese" value="'.date("m").'"/><br>
				<i>Giorno:</i><input type="text" name="visita_medica_giorno" value="'.date("d").'"/><br>
				<i>Ora:</i><input type="text" name="visita_medica_giorno" value="'.date("H").'"/><br>
				<i>Minuti:</i><input type="text" name="visita_medica_giorno" value="'.date("i").'"/></td></tr>
 * */
echo '<table>
	<tr><td><b>Tipologia:</b></td><td><input type="text" name="visita_medica_tipo" /></td></tr>
		<tr><td><b>Motivazione:</b></td><td><textarea name="visita_medica_motivazione" rows="5" cols="40"></textarea></td></tr>
		<tr><td><b>Esame clinico:</b></td><td><textarea name="visita_medica_esame_clinico" rows="5" cols="40"></textarea></td></tr>
		<tr><td><b>Diagnosi:</b></td><td><textarea name="visita_medica_diagnosi" rows="5" cols="40"></textarea></td></tr>
		<tr><td><b>Richiesta esami:</b></td><td><textarea name="visita_richiesta_esami" rows="5" cols="40"></textarea></td></tr>
		<tr><td><b>Farmaci attualmente assunti:</b></td><td><textarea name="visita_farmaci_attuali_assunzione" rows="5" cols="40"></textarea></td></tr>
		<tr><td><b>Terapia prescritta:</b></td><td><textarea name="visita_richiesta_terapia_prescritta" rows="5" cols="40"></textarea></td></tr>
		<tr><td><b>Farmaci consegnati:</b></td><td><textarea name="visita_richiesta_farmaci_prescritti" rows="5" cols="40"></textarea></td></tr>
		<tr><td><b>Farmaci prescritti tramite ricetta:</b></td><td><textarea name="visita_richiesta_farmaci_prescritti_ricetta" rows="5" cols="40"></textarea></td></tr>
		<tr><td><b>Data prossima visita:</b></td><td>
				<i>Anno:</i><input type="text" name="visita_medica_data_ventura_anno" /><br>
				<i>Mese:</i><input type="text" name="visita_medica_data_ventura_mese" /><br>
				<i>Giorno:</i><input type="text" name="visita_medica_data_ventura_giorno" /><br>
				<i>Ora:</i><input type="text" name="visita_medica_data_ventura_ora" /><br>
				<i>Minuti:</i><input type="text" name="visita_medica_data_ventura_minuti" /></td></tr>
	</table>
	<input type="hidden" name="paziente_id" value="'.$id_paziente.'"/>
	<input type="submit" name="aggiungi_visita" value="Salva visita"/>';
echo '</form></div>';
}
?>