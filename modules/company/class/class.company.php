<?
class TCompany extends TObjetStd {
	
	public $objectName = 'company';
	
	function __construct() {
		
		$this->set_table( DB_PREFIX.$this->objectName );
		
		$this->addFields('isEntity,id_entity','type=entier;index;');
		$this->addFields('isCustomer,isSupplier','type=entier;index;');
		$this->addFields('capital','type=float;');
		$this->addFields('customerRef,supplierRef,name,legalForm,vat_intra,vat_subject,phone,fax,email,web','type=chaine;');
		
		TAtomic::initExtraFields($this);

		$this->start();
		$this->_init_vars();

		$this -> setChild('TAddress', 'id_company');
		$this -> setChild('TContactToObject', array('id_object', $this->objectName) );
		$this -> setChild('TCategoryLink', array('id_object', $this->objectName) );
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
	
	static function getCustomerForCombo(&$db, $id_entity) {
		return TCompany::getCompanyForCombo($db, 1, $id_entity);
	}
	
	static function getCompanyForCombo(&$db, $customers=null,  $idEntities='') {
		
		$sql="SELECT id,name FROM ".DB_PREFIX."company WHERE 1";
		
		if(!is_null($customers)) $sql.=' AND isCustomer='.$customers;
		
		if(!empty($idIn)) $sql.=' AND id_entity IN ('.$idIn.') ';
		
		
		return TRequeteCore::get_keyval_by_sql($db, $sql, 'id', 'name');
		
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
	static function getEntityTags(&$db, $idIn='', $idOut='') {
		
		$sql="SELECT DISTINCT CONCAT(e.id,'. ',e.name) as 'tag' FROM ".DB_PREFIX."company e WHERE isEntity=1";
		if(!empty($idIn)) $sql.=' AND id IN ('.$idIn.') ';
		if(!empty($idOut)) $sql.=' AND id NOT IN ('.$idOut.') ';
		
		$db->Execute($sql);
		$Tab=array();
		
		while($db->Get_line()) {
			$Tab[] = $db->Get_field('tag');
		}
		
		return $Tab;
	}
	static function getEntityUsers(&$db, $id_entity=0) {
		$sql = "SELECT u.id FROM ".DB_PREFIX."contact u ";
		$sql.= "LEFT JOIN ".DB_PREFIX."contact_to_object cto ON (u.id = cto.id_contact) ";
		$sql.= "LEFT JOIN ".DB_PREFIX."company c ON (c.id = cto.id_object AND cto.objectType = 'company') ";
		$sql.= "WHERE c.id_entity=$id_entity AND u.isUser=1";
		
		return TRequeteCore::_get_id_by_sql($db, $sql);
	} 
	
}
