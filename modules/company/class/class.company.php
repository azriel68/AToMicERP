<?
class TCompany extends TObjetStd {
	function __construct() {
		
		parent::set_table(DB_PREFIX.'company');
		
		parent::add_champs('isEntity,id_entity','type=entier;index;');
		parent::add_champs('name,phone,fax,email,web','type=chaine;');
		
		TAtomic::initExtraFields($this);

		parent::start();
		parent::_init_vars();

		$this -> setChild('TAddress', 'id_company');
		$this -> setChild('TContact', 'id_company');
	}
	
	static function getEntityForCombo(&$db) {
		
		$sql="SELECT id,name FROM company WHERE isEntity=1";
		
		return TRequeteCore::get_keyval_by_sql($db, $sql, 'id', 'name');
		
	}
}
