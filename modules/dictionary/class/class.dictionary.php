<?php
class TDictionary extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'dictionary');
		//parent::add_champs('','type=entier;');
		parent::add_champs('label','type=chaine;');
		parent::add_champs('code,type','type=chaine;index;');
		parent::add_champs('valid','type=entier;index;');
			
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
	
	static function get(&$db, $type, $code='') {
		$TRes = TRequeteCore::get_id_from_what_you_want($db, DB_PREFIX.'dictionary', array('type'=>$type, 'valid'=>1), 'code');
		
		$TList = array();
		foreach($TRes as $key) {
			$TList[$key] = __tr($key);
		}
		return $TList;
	}
	static function set(&$db, $type, $code) {
		
	}
}

