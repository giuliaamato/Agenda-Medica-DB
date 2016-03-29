<?php
class html_lib {
	
	public function header($title, $extra = null){
    return '<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style>
table {
	border: 1px solid black;
    width: 90%;
}
tr{
	width: 90%;	
}
td{
   	padding: 0px 10px 0 10px;
	vertical-align: top;
   	border-bottom: 1px solid black;
}
body{
	width: 90%;	
}
td input{
	width: 100%;	
}
textarea{
	width: 100%;	
}
#nav{
    border: 0px;
   	text-align:center;
}
#nav tr{
	width: auto;
    display: table;
}
#nav input{
	width: auto;
}
#nav td{
    width: 100px;
    border: 0px;
}
</style>
<title>'.$title.'</title>'
.$extra.
'</head>';
	}
}

?>