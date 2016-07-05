<!DOCTYPE html>
<html>
<body>

<?php

include("db_config.php");

$spec = $_GET['s'];
$asl = $_GET['asl'];


$conn = new DBConfig();

$rows = $conn->db_query("SELECT Dottore.CodiceFiscale, Informazioni.Nome, Informazioni.Cognome FROM Dottore JOIN Informazioni ON Dottore.CodiceFiscale=Informazioni.CodiceFiscale WHERE Informazioni.CodiceASL=".$asl." AND Dottore.Specializzazione='".$spec."'");

echo json_encode($rows);

for ($i=0; $i < count($rows) ; $i++) { 
    $d = $rows[$i];
    echo "<option>".$d['CodiceFiscale']." - ".$d['Nome']." ".$d['Cognome']."</option>";
}



?>
</body>
</html>