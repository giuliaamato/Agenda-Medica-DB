<?php
  
  include("db_config.php");

  session_start();

  if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $db_conn = new DBConfig();

    $username = $_POST['username'];
    $password = $_POST['password'];

    $rows = $db_conn->db_query("SELECT CodiceFiscale FROM Dottore,DatiAccesso WHERE DatiAccesso.NomeUtente='".$username."' AND DatiAccesso.Password='".$password."' AND Dottore.NomeUtente='".$username."';");

    if(count($rows) > 0){

      $_SESSION['username'] = $username;
      $_SESSION['codice_fiscale'] = $rows[0]['CodiceFiscale'];
      $_SESSION['logged_as'] = 'dottore';

      header("Location: indexdottore.php");
      die();

    }

  } else {

    if (isset($_SESSION['username']) && $_SESSION['logged_as'] == 'dottore'){

      header("Location: indexdottore.php");
      die();

    }


  }



?>

<!doctype html>
<html>
<head>
    <title>Login Dottore</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">


</head>

<body>


<nav class="navbar navbar-default">
  <div class="navbar-header">
    <a class="navbar-brand" href="index.html">Pagina iniziale</a>
  </div>
</nav>

<div class="container">
  

<h1> Login Dottore </h1>


<form method="POST" action="#">
  <div class="form-group">
    <label>Nome Utente</label>
    <input name="username" class="form-control" placeholder="Nome Utente">
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
