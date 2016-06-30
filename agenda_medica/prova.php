<?php

	$oraCorrente = new DateTime('09:30:00');
	$oraFine = new DateTime('17:30:00');
	
	while ($oraFine > $oraCorrente){
		echo $oraCorrente->format('H:i:s')."\n";
		date_add($oraCorrente, date_interval_create_from_date_string('30 min'));
		
	}




?>