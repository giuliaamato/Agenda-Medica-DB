<?php
	
	session_start();

	if (isset($_SESSION['username']) && $_SESSION['logged_in']=true){

		echo "Welcome ".$_SESSION['username'];

	} else {

		header("Location: http://localhost/agenda_medica/loginCUP.php");
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

	<h1>Agenda Medica</h1>




</div>
</body>
</html>
