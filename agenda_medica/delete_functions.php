<?php

	include_once("db_config.php");

	// Funzione di cancellazione della visita medica
	function delete_visita($cod_visita){

		$conn = new DBConfig();

		$conn->db_query("DELETE FROM VisitaMedica WHERE CodiceVisita=".$cod_visita);

	}

	// Cancellazione di paziente, infermiere e dottore
	function delete_persona($cf)
	{
		$conn = new DBConfig();
		$conn->db_query("DELETE FROM Informazioni WHERE CodiceFiscale='".$cf."'");
	}




?>