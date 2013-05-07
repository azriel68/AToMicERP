<?
class TConf extends TObjetStd {
	function __construct() {
		
		parent::set_table(DB_PREFIX.'conf');
		
		parent::add_champs('id_entity','type=entier;index;');
		parent::add_champs('confKey,confVal','type=chaine;');
		
		TAtomic::initExtraFields($this);

		parent::start();
		parent::_init_vars();
	}
	
	static function loadConf(&$db, $id_entity) {
		$sql = "SELECT confKey, confVal FROM ".DB_PREFIX."conf WHERE id_entity = ".$id_entity;
		return TRequeteCore::get_keyval_by_sql($db, $sql, 'confKey', 'confVal');
	}
	
	static function get(&$db, $id_entity, $confKey) {
		$TRes = TRequeteCore::get_id_from_what_you_want($db, DB_PREFIX.'conf', array('id_entity'=>$id_entity, 'confKey'=>$confKey), 'confVal');
		return !empty($TRes[0]) ? $TRes[0] : false;
	}
}