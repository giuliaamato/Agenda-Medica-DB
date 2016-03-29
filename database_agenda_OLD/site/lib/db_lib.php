<?php

class db_lib{
	
	private $db_server="localhost";
	private $db_user="root";
	private $db_pwd="psw";
	private $db_db="cucine_popolari";
	
	private $db_link = null;
	
	
	
	private function make_dbconnection(){
		$this->db_link = new mysqli($this->db_server,$this->db_user,$this->db_pwd, $this->db_db);
		if ($this->db_link->connect_error) {
			die("Connection failed: " . $this->db_link->connect_error);
		}
	}
	
	public function query($sql){
		if($this->db_link == null){
			$this->make_dbconnection();
		}
		$result = $this->db_link->query($sql);
		
		//echo $result;
		
		$row_all = array();
		if($result && !is_bool ($result)){
			$i=0;
			while($row = $result->fetch_assoc()) {
				$row_all[$i++] = $row;
			}
			$this->db_link->close();
			$this->db_link=null;
		}
		return $row_all;
	}
	
}

?>