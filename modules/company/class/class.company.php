<?
class TCompany extends TObjetStd {
	function __construct() {
		
		parent::set_table(DB_PREFIX.'company');
		
		parent::add_champs('isEntity,id_entity','type=entier;index;');
		parent::add_champs('isCustomer,isSupplier','type=entier;index;');
		parent::add_champs('capital','type=float;');
		parent::add_champs('customerRef,supplierRef,name,legalForm,vat_intra,vat_subject,phone,fax,email,web','type=chaine;');
		
		TAtomic::initExtraFields($this);

		parent::start();
		parent::_init_vars();

		$this -> setChild('TAddress', 'id_company');
		$this -> setChild('TContactToObject', array('id_object', 'company') );
	}
	
	function save(&$db) {
		// Set customer Ref
		if(empty($this->customerRef) && $this->isCustomer == 1) {
			$this->customerRef = TNumbering::getNextRefValue($db, $this, 'customerRef');
		}
		
		// Set supplier Ref
		if(empty($this->supplierRef) && $this->isSupplier == 1) {
			$this->supplierRef = TNumbering::getNextRefValue($db, $this, 'supplierRef');
		}
		
		return parent::save($db);
	}
	function contactExist(&$contact) {
		//pre($this->TContactToObject_company);	
		foreach($this->TContactToObject_company as &$link) {
			if($link->id_contact == $contact->getId()) return true;	
		}
		
		return false;
	}
	function addContact(&$contact) {
		if(!$this->contactExist($contact)) {
			$iLien = $this->addChild($db, 'TContactToObject_company');
			
			if(!isset($this->TContactToObject_company[$iLien]))$this->TContactToObject_company[$iLien]=new TContactToObject; // A quoi sert  cette ligne ? 
	
			$this->TContactToObject_company[$iLien]->id_contact = $contact->getId();
			
		}
		
	}
	function getContactForCombo(&$db, $id_contactExclude) {
		
		$TContact=array();
		
		foreach($this->TContactToObject_company as &$link) {
			if($link->id_contact != $id_contactExclude) {
				
				if(empty($link->contact)) {
					$link->contact=new TContact;
					$link->contact->load($db, $link->id_contact);
				}
				
				$TContact[$link->contact->id] = $link->contact->name();
				
			}	
		}
		
		return $TContact;
		
	}
}

class TEntity extends TCompany {
	
	static function getEntityForCombo(&$db, $idIn='', $idOut='') {
		
		$sql="SELECT id,name FROM ".DB_PREFIX."company WHERE isEntity=1";
		if(!empty($idIn)) $sql.=' AND id IN ('.$idIn.') ';
		if(!empty($idOut)) $sql.=' AND id NOT IN ('.$idOut.') ';
		
		
		return TRequeteCore::get_keyval_by_sql($db, $sql, 'id', 'name');
		
	}
	
	static function getEntityUsers(&$db, $id_entity=0) {
		$sql = "SELECT u.id FROM ".DB_PREFIX."contact u ";
		$sql.= "LEFT JOIN ".DB_PREFIX."contact_to_object cto ON (u.id = cto.id_contact) ";
		$sql.= "LEFT JOIN ".DB_PREFIX."company c ON (c.id = cto.id_object AND cto.objectType = 'company') ";
		$sql.= "WHERE c.id_entity=$id_entity AND u.isUser=1";
		
		return TRequeteCore::_get_id_by_sql($db, $sql);
	} 
	
}
