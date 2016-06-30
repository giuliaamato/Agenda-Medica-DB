<!DOCTYPE html>
<html>
<body>

<?php

include("db_config.php");

$option = $_GET['s'];
$option2 = $_GET['o'];
$cf = $_GET['cf'];

$conn = new DBConfig();

$rows = $conn->db_query("CALL ambulatori_disp('".$option."','".$option2."','".$cf."')");



for ($i=0; $i < count($rows) ; $i++) { 
    $a = $rows[$i];
    echo "<option>".$a['Nome']."</option>";
}



?>
</body>
</html>