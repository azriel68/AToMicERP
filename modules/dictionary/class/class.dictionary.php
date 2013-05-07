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
	
	/**
	 * Load dictionnary from database, translate labels and return array
	 * Called only after login, translations based on user lang
	 */
	static function loadDictionary(&$db, $id_entity) {
		$sql = "SELECT type, code, label FROM ".DB_PREFIX."dictionary WHERE id_entity = ".$id_entity." AND valid = 1 ORDER BY type";
		$db->Execute($sql);
		
		$TDict = array();
		while ($db->Get_line()) {
			if(empty($TDict[$db->Get_field('type')])) $TDict[$db->Get_field('type')] = array();
			$TDict[$db->Get_field('type')][$db->Get_field('code')] = __tr($db->Get_field('label'));
			// Alpha order for each type
			asort($TDict[$db->Get_field('type')]);
		}
		return $TDict;
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

