<?php
	
	session_start();
	include ('db_config.php');

	if (!$_SESSION['logged_as'] == 'cup' && !isset($_SESSION['cod_asl'])){

		header("Location: loginCUP.php");
		die();

	}



?>

<!doctype html>
<html>
<head>
    <title></title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    
</head>


<body>

<div class="container">
<?php
	
	$db_conn = new DBConfig();
	$row = $db_conn->db_query("SELECT * FROM ASL WHERE ASL.Codice=".$_SESSION['cod_asl'].";");
	
	if (count($row) == 1){

		$asl = $row[0];

		echo "<h1>Centro Unico Prenotazioni della ASL di ".$asl['CittaSede']."</h1>";



	}

		
?>



</div>
</body>
</html>
