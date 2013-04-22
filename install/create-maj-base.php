<?php
/*
 * Script créant et vérifiant que les champs requis s'ajoutent bien
 * 
 */
	require('../config.php');
	
	$ATMdb=new TPDOdb;
	
	$TClass = get_declared_classes();
	
	foreach($TClass as $className) {
		
		$o=new $className;
		
		if(method_exists ($o, 'init_db_by_vars')) {
			$o->init_db_by_vars($ATMdb);
		} 
		
	}
