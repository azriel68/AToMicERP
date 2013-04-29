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
		$this -> setChild('TContactToObject', array('id_object', 'company') );
	}
	
	function addContact(&$contact) {
		
		$iLien = $this->addChild($db, 'TContactToObject_company');
		$this->TContactToObject_company[$iLien]->id_contact = $contact->getId();
		
	}
	
}

class TEntity extends TCompany {
	
	static function getEntityForCombo(&$db) {
		
		$sql="SELECT id,name FROM ".DB_PREFIX."company WHERE isEntity=1";
		
		return TRequeteCore::get_keyval_by_sql($db, $sql, 'id', 'name');
		
	}
	
}
