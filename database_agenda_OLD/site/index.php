<?php
require(dirname(__FILE__)."/lib/html_lib.php");
require(dirname(__FILE__)."/lib/var_common.php");
require(dirname(__FILE__)."/lib/db_lib.php");

$title = "Inizio";

$vars = new var_common();
$html = new html_lib();

echo $html->header($vars->get_app_title()." - ".$title);

echo "\n<body>
<h1>".$vars->get_app_title()."</h1>";

$session_id = mt_rand();

if(isset($_GET[$vars->get_session_sid()])){
	$session_id = $_GET[$vars->get_session_sid()];
}

//setup nome alla sessione
session_name($vars->get_session_name($session_id));
//creazione (se gia' esistente crea un warning)
session_start();
if(!isset($_POST["verify_login"])){// && !isset($_POST["medico_id"])){
	echo '<h2>Accesso</h2>
	<form method="POST" action="index.php">
	<table style="border:0px"><tr>
			<td>Nome: <input type="text" name="medico_nome"></td>
			<td>Cognome: <input type="" name="medico_cgn"></td>
			<td>Password: <input type="password" name="medico_psw"></td>
			</tr>
	</table>
	<input type="hidden" name="verify_login" value="true">
   <input type="submit" name="submit" value="Accedi" />
</form>
</body></html>';
	return;
}

$db = new db_lib();
// JOIN `admin` ON `utente.utente_id`=`admin.admin_id` 
$sql_string = "SELECT * FROM `utente` WHERE `utente`.`nome` LIKE '".trim($_POST["medico_nome"])."' AND  `utente`.`cognome` LIKE '".trim($_POST["medico_cgn"])."' AND  `utente`.`password` = '".trim($_POST["medico_psw"])."'";

$res = $db->query($sql_string);
if(count($res) > 0){
	$user_id = $res[0]["utente_id"];
	$sql_string = "SELECT * FROM `utente` JOIN `medico` ON `utente_id` = `medico_id` WHERE `medico_id` = ".$user_id;
	$res = $db->query($sql_string);
	$match = false;
	if(count($res) > 0){
		$_SESSION["medico_id"] = $res[0]["medico_id"];
		$match = true;
	}

	if(!$match){
		$sql_string = "SELECT * FROM `utente` JOIN `admin` ON `utente_id` = `admin_id` WHERE `admin_id` = ".$user_id ;
		$res = $db->query($sql_string);
		if(count($res) > 0){
			$_SESSION["admin_id"] = $res[0]["admin_id"];
			$match = true;
		}
	}
	if(!$match){
		echo '<p>Credenziali di utente non valide!</p><p><a href="index.php">Reinserire i dati per una nuova login</a></p>';
		return;
	}
}
else{
	echo '<p>Credenziali di utente non valide!</p><p><a href="index.php">Reinserire i dati per una nuova login</a></p>';
	return;
}

$is_admin = false;
$sql_string = "";
if(isset($_SESSION["admin_id"])){
	$is_admin = true;
	$sql_string  = "select * from utente JOIN admin ON utente_id = admin_id where admin_id=".$_SESSION["admin_id"];
}
else{
	$sql_string  = "select * from utente JOIN medico ON utente_id = medico_id where medico_id=".$_SESSION["medico_id"];
}
$res = $db->query($sql_string);
echo 'Accesso effettuato come <b>'.$res[0]["nome"]." ".$res[0]["cognome"].'<b>';
echo '<table id="nav"><tr>';
	if($is_admin){
		echo '<td><a href="medici.php?'.$vars->get_session_sid().'='.$session_id.'">
						<img src="img/doctor.png" height="48px" alt="Medici"/>
					</a><br>Gestione Medici</td>';
	}
	else{
		echo '<td><a href="pazienti.php?'.$vars->get_session_sid().'='.$session_id.'">
					<img src="img/medical.png" height="48px" alt="Pazienti e visite mediche"/>
				</a><br>Gestione Pazienti e visite mediche</td>';
	}
	
echo '<td><a href=".">
					<img src="img/reset.png" height="48px" alt="Reset"/>
				</a><br>Chiudi sessione di lavoro</td></tr></table></body></html>';

?>