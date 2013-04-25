<?php
class TDictionnary extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'dictionnary');
		//parent::add_champs('','type=entier;');
		parent::add_champs('label','type=chaine;');
		parent::add_champs('code,type','type=chaine;index;');
		parent::add_champs('valid','type=entier;index;');
			
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
	
	static function get($type, $code='') {
		
	}
	static function set($type, $code) {
		
	}
}

