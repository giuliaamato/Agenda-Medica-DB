<!doctype html>
<html>
<head>
    <title>AJAX Try</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">


</head>

<body>
<div class="container">

  

  <form>
    <select name="data" onchange="mostraAmbulatori(this.value)">
      <option>first</option>
      <option>second</option>  
    </select>
    
    <select id="ambulatorio"></select>


  </form>

<script>

  function mostraAmbulatori(option){

      var xhttp = new XMLHttpRequest();
      
      xhttp.onreadystatechange = function(){

        if (xhttp.readyState == 4 && xhttp.status == 200){
          document.getElementById('ambulatorio').innerHTML = xhttp.responseText;
        }
      };
      xhttp.open("GET",'get_ambulatori.php?d='+option);
      xhttp.send();

  }

</script>
</div>
</body>
</html>
