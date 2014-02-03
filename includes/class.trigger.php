<?php

class TTrigger {
	
	function __construct() {
		$this->TTrigger=array();
	}
	static function run(&$ATMdb, &$object, $className, $state) {
	global $conf;
	
		/* Execute the triggers */
	
		if(empty($conf->TTrigger)) return false;
	
		foreach($conf->TTrigger as &$trigger) {
			
				if(class_exists($trigger['objectName'])) {
					
					if(method_exists($trigger['objectName'],'trigger')) {
						$result = call_user_func_array(array($trigger['objectName'],'trigger'), array(&$ATMdb, &$object, $className, $state) );
					}

				}			
		}
		
	}
	
	static function register($objectName, $priority = 99) {
		global $conf;
		/*  */
		
		//TODO add db
		
		$conf->TTrigger[]=array('objectName'=>$objectName, 'priority'=>$priority);
		
		TTrigger::orderTrigger($conf->TTrigger);
		
	}
	static function orderTrigger(&$TTrigger) {
		
		
		
	}
	
	function loadTrigger(&$ATMdb) {
		/* Charge la liste des triggers à exécuter */
		$this->TTrigger=array();
		
		
		return $this->TTrigger;
	}
}
