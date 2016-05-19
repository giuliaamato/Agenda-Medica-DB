<!doctype html>
<html>
<head>
    <title>Login</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">


</head>

<body>
<div class="container">

<h1> Login </h1>

<p><a href="loginCUP.php">Accesso CUP</a></p>

<form method="POST" action="#">
  <div class="form-group">
    <label>Nome Utente</label>
    <input type="email" class="form-control" placeholder="Nome Utente">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  
  <button type="submit" class="btn btn-default">Submit</button>
</form>
</div>
</body>
</html>
