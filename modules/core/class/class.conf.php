<?
class TConf extends TObjetStd {
	function __construct() {
		
		parent::set_table(DB_PREFIX.'conf');
		
		parent::add_champs('id_entity,visible','type=entier;index;');
		parent::add_champs('confKey,confVal,description','type=chaine;');
		
		TAtomic::initExtraFields($this);

		parent::start();
		parent::_init_vars();
	}
	
	static function loadConf(&$db, $id_entity) {
		$sql = "SELECT confKey, confVal FROM ".DB_PREFIX."conf WHERE id_entity IN( ".$id_entity .")";
		return TRequeteCore::get_keyval_by_sql($db, $sql, 'confKey', 'confVal');
	}
	
	function load_by_key_and_entity($db, $key, $id_entity, $onlyThisEntity=false) {
		
		$entities = ($onlyThisEntity) ? $id_entity : '0,'.$id_entity;
		
		$sql = "SELECT id FROM ".$this->get_table()."
		WHERE confKey=".$db->quote($name)." AND id_entity IN (".$entities.")";
		
		$sql.=" ORDER BY id_entity DESC LIMIT 1";
		$db->Execute($sql);
		
		if($row = $db->Get_line()) {
			return $this->load($db, $row->id);
			
		}
		
		return false;	
	}
	
	static function get(&$db,$id_entity, $confKey) {
		global $conf;
		
		$c=new TConf;
		$c->load_by_key_and_entity($db, $confKey, $id_entity);
		
		return $c->confVal;
		
	}
	
	static function set(&$db,$id_entity, $key, $value, $description='') {
		
		$c=new TConf;
		$c->load_by_key_and_entity($db, $key, $id_entity, true);
		
		$c->id_entity = $id_entity;
		$c->name = $name;
		$c->value = $value;
		$c->description = $description;
		
		$c->save($db);
		
	}
	
}