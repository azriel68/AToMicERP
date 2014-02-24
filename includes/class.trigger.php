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
	
	static function register($objectName, $priority = 99, $method='trigger') {
		global $conf;
		/*  */
		
		//TODO add db
		
		$conf->TTrigger[]=array('objectName'=>$objectName, 'priority'=>$priority, 'method'=>$trigger);
		
		TTrigger::sortTrigger($conf->TTrigger);
		
	}
	static function sortTrigger(&$TTrigger) {
		
		usort($TTrigger, array('TTriger', '_sortTrigger_fct'));
		
	}
	static function _sortTrigger_fct($a, $b) {
		
		if($a['priority']<$b['priority']) return -1;
		else if($a['priority']>$b['priority']) return 1;
		return 0;
		
	}
	
	function loadTrigger(&$ATMdb) { // Delete or not ? Trigger store in db or not ?
		/* Charge la liste des triggers à exécuter */
		$this->TTrigger=array();
		
		
		return $this->TTrigger;
	}
}
