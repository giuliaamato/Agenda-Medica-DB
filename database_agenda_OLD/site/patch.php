<?php
require(dirname(__FILE__)."/lib/html_lib.php");
require(dirname(__FILE__)."/lib/var_common.php");
require(dirname(__FILE__)."/lib/db_lib.php");

$db = new db_lib();
$res = $db->query("ALTER TABLE `utente` ADD `domicilio_provincia` VARCHAR(50) NULL DEFAULT NULL");
echo "Patch applicata, eliminare il file!";

?>
