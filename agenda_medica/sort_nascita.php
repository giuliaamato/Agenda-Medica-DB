<!DOCTYPE html>
<html>
<body>

<?php

include("db_config.php");

$cf = $_GET['cf'];

$conn = new DBConfig();

$rows = $conn->db_query("SELECT I.Nome, I.Cognome, I.DataNascita, VM.CFPaziente, I.CodiceASL, VM.CodiceVisita, 
	VM.Data, VM.NomeAmbulatorio, VM.TipoVisita, VM.Priorita, VM.CFDottore, VM.CFInfermiere, 
	VM.CodiceReferto,VM.TipoPrenotazione FROM VisitaMedica VM  JOIN Informazioni I 
	WHERE VM.CFPaziente = I.CodiceFiscale AND VM.TipoPrenotazione = 0 AND VM.CFDottore='".$cf."' ORDER BY I.DataNascita");

echo "<tr>
				<th>Data Visita</th>
				<th>Priorità</th>
				<th>Ambulatorio</th>
				<th>Paziente</th>
				<th>Azione</th>
		</tr>";


for ($i=0; $i < count($rows) ; $i++) { 

		$v = $rows[$i];

		if ($v['TipoPrenotazione'] == 0){ // Visite prenotate

		echo "<tr>";
		echo "<td>".$v['Data']."</td>";
		echo "<td>".$v['Priorita']."</td>";
		echo "<td>".$v['NomeAmbulatorio']."</td>";
		echo "<td><form method='GET' action='info_paziente.php'><input type='hidden' name='cf_paziente' value='".$v['CFPaziente']."'/><button class='btn btn-primary'>".$v['CFPaziente']."</button></form></td>";
		echo "<td><form method='POST' action='indexdottore.php'><input type='hidden' name='codice_visita' value='".$v['CodiceVisita']."' /><button class='btn btn-danger'>Cancella</button></form></td>";
		echo "</tr>";

		}
}




?>
</body>
</html>