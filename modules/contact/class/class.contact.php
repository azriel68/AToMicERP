<?php
class TContact extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'contact');
		parent::add_champs('status,id_entity','type=entier;index;');
		parent::add_champs('lastname,firstname,phone,fax,email,lang,id_manager','type=chaine;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
		
		$this->lang = DEFAULT_LANG;
		
		$this->setChild('TAddress', 'id_contact');
		$this->setChild('TContactToObject', 'id_contact');
	}
	
	function name() {
		return $this->firstname.' '.$this->lastname;
	}
	
	function gravatar($size=100) {
		return TTemplate::gravatar($this->email, $this->name(), $size);
	}
}

/*
 * Link to company and project
 */
class TContactToObject extends TObjetStd {
	function __construct() {
		parent::set_table(DB_PREFIX.'contact_to_object');
		parent::add_champs('id_contact,id_object','type=entier;index;');
		parent::add_champs('objectType,type','type=chaine;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}
