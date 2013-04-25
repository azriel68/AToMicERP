<?
class TCompany extends TObjetStd {
	function __construct() {
		
		parent::set_table('company');
		
		parent::add_champs('isEntity,id_entity','type=entier;index;');
		parent::add_champs('name','type=chaine;');
		
		TAtomic::initExtraFields($this);

		parent::start();
		parent::_init_vars();

		$this -> setChild('TAddress', 'id_company');
		$this -> setChild('TContactToObject', array('id_object', 'company') );
	}
	
}

class TEntity extends TCompany {
	
	static function getEntityForCombo(&$db) {
		
		$sql="SELECT id,name FROM company WHERE isEntity=1";
		
		return TRequeteCore::get_keyval_by_sql($db, $sql, 'id', 'name');
		
	}
	
}
