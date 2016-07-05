<!DOCTYPE html>
<html>
<body>

<?php

include("db_config.php");

$db_conn = new DBConfig();

$dott = $_GET['d'];

$res1 = $db_conn->db_query("SELECT OraInizio('".$dott."') AS OraInizio");
$res2 = $db_conn->db_query("SELECT OraFine('".$dott."') AS OraFine");



$oraCorrente = new DateTime($res1[0]['OraInizio']);
$oraFine = new DateTime($res2[0]['OraFine']) ;

while ($oraFine > $oraCorrente){
    echo "<option>".$oraCorrente->format('H:i:s')."</option>";
    date_add($oraCorrente, date_interval_create_from_date_string('30 min'));
}


?>
</body>
</html>