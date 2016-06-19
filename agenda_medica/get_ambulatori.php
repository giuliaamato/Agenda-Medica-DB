<!DOCTYPE html>
<html>
<body>

<?php

include("db_config.php");

$option = $_GET['d'];


$conn = new DBConfig();

$rows = $conn->db_query("SELECT Nome FROM Ambulatorio");



for ($i=0; $i < count($rows) ; $i++) { 
    $a = $rows[$i];
    echo "<option>".$a['Nome']."</option>";
}



?>
</body>
</html>