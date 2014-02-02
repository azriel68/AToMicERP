<?php

class TTrigger {
	
	function __construct() {
		$this->TTrigger=array();
	}
	static function run(&$ATMdb, &$object, $className, $state) {
	global $conf;
	
		/* Execute the triggers */
	
		foreach($conf->TTrigger as &$trigger) {
			
				if(class_exists($trigger['objectName'])) {
					
					if(method_exists($trigger['objectName'],'trigger')) {
						$result = call_user_func(array($hook['object'],$hook['function']), $ATMdb, $object, $className, $state );
					}

				}			
		}
		
	}
	
	function register(&$ATMdb, $objectName) {
		global $conf;
		/* Enregistre un nouveau trigger avec le chemin à charger et la method à appeler */
		
		//TODO add db
		
		$conf->TTrigger[]=array('objectName'=>$objectName);
		
	}
	function loadTrigger(&$ATMdb) {
		/* Charge la liste des triggers à exécuter */
		$this->TTrigger=array();
		
		
		return $this->TTrigger;
	}
}
