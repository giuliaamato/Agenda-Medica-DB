<?php

/**
* 
*/
class DBConfig
{
	private $db_server = "localhost";
	private $db_password = "e4wYK8na";
	private $db_username = "pbroglio";
	private $db_name = "pbroglio-PR";

	private $db_conn = null;

	// CONNESSIONE AL DATABASE
	private function db_connection(){

		$this->db_conn = new mysqli($this->db_server, $this->db_username, $this->db_password, $this->db_name);


		if ($this->db_conn->connect_error){

			die("Connection failed: ".$this->db_conn->connect_error);

		}
	}

	// ESEGUE QUERY $sql
	public function db_query($sql){


		if($this->db_conn == null){

			$this->db_connection();

		}

		$result = $this->db_conn->query($sql);

		$rows = array();

		if ($result && !is_bool($result)){

			$i = 0;

			while ($row = $result->fetch_assoc()){

				$rows[$i++] = $row;

			}

			$this->db_conn->close();
			$this->db_conn = null;

		} 

		return $rows;


	}


}


?>
