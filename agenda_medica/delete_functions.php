<?php

	include_once("db_config.php");

	// Funzione di cancellazione della visita medica
	function delete_visita($cod_visita){

		$conn = new DBConfig();

		$conn->db_query("DELETE FROM VisitaMedica WHERE CodiceVisita=".$cod_visita);

	}



?>