<?php
  
  session_start();
  include ('db_config.php');

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $db_conn = new DBConfig();

    $codice = $_POST['codice'];
    $password = $_POST['password'];

    $row = $db_conn->db_query("SELECT * FROM ASL WHERE ASL.Codice=(SELECT CodiceASL FROM CUP WHERE CUP.Codice='".$codice."' AND CUP.Password='".$password."')");

    if (count($row) > 0){

      $cod_asl = $row[0]['Codice'];

      $_SESSION['logged_as'] = 'cup';
      $_SESSION['cod_asl'] = $cod_asl;

      header('Location: indexcup.php');
      die();

    }



  }

?>



<!doctype html>
<html>
<head>
    <title>Login CUP</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    
</head>

<body>
<nav class="navbar navbar-default">
  <div class="navbar-header">
    <a class="navbar-brand" href="../index.html">Pagina iniziale</a>
  </div>
</nav>



<div class="container">
<h1>Login CUP</h1>
<form method="POST" action="#">
  <div class="form-group">
    <label>Codice</label>
    <input name="codice" class="form-control" placeholder="Codice">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  
  <button type="submit" class="btn btn-default">Submit</button>
</form>
    
</div>
</body>
</html>
