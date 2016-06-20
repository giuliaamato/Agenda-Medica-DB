<?php

	include_once("db_config.php");

	// Funzione di cancellazione della visita medica
	function delete_visita($cod_visita){

		$conn = new DBConfig();

		$conn->db_query("DELETE FROM VisitaMedica WHERE CodiceVisita=".$cod_visita);

	}

	// Funzione di cancellazione di un dottore dato il suo Codice Fiscale
	function delete_dottore($cf_dott)
	{
		$conn = new DBConfig();
		$conn->db_query("DELETE FROM Dottore WHERE CodiceFiscale='".$cf_dott."'");
	}

	// Funzione di cancellazione di un infermiere
	function delete_infermiere($cf_inf){

		$conn = new DBConfig();
		$conn->db_query("DELETE FROM Infermiere WHERE CodiceFiscale='".$cf_inf."'");

	}



?>