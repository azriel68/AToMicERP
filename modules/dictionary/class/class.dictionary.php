<?php
class TDictionary extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'dictionary');
		parent::add_champs('id_entity,valid','type=entier;index;');
		parent::add_champs('label','type=chaine;');
		parent::add_champs('code,type','typeconf=chaine;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
	
	
	static function get(&$db, &$user, $type, $id_entity, $code='') {
		
		if(isset($user->dictionary[$id_entity][$type])) {
			$TDictionnary= & $user->dictionary[$id_entity][$type];
		}
		else {
			$TDictionnary = TRequeteCore::get_keyval_by_sql($db, "SELECT code, label FROM ".DB_PREFIX."dictionary WHERE id_entity = ".$id_entity." AND valid = 1 AND type='".$type."'", 'code', 'label');	
		}
		
		$TList = array();
		foreach($TDictionnary as $key=>$value) {
			$TList[$key] = __tr($value);
		}
		
		natsort($TList);
		
		return $TList;
	}
	static function set(&$db, $type, $code) {
				
			
		
	}
}

