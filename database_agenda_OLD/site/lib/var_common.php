<?php

class var_common{

	private $session_name="AgendaMedicaCucinePopolari-";
	private $session_sid = "sid";
	private $app_title = "Agenda Medica Cucine Economiche Popolari di Padova";
	
	public function get_session_name($id){
		return $this->session_name.$id;
	}

	public function get_session_sid(){
		return $this->session_sid;
	}
	
	public function get_app_title(){
		return $this->app_title;
	}
	
}

?>