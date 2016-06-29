<!DOCTYPE html>
<html>
<body>

<?php

include("db_config.php");

$option = $_GET['s'];


$conn = new DBConfig();

$rows = $conn->db_query("CALL ambulatori_disp('".$option."','".$_SESSION['codice_fiscale']."')");



for ($i=0; $i < count($rows) ; $i++) { 
    $a = $rows[$i];
    echo "<option>".$a['Nome']."</option>";
}



?>
</body>
</html>