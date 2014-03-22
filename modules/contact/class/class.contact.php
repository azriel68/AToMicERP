<?php
class TContact extends TObjetStd {
	function __construct() { 
		$this->set_table(DB_PREFIX.'contact');
		$this->add_champs('status,id_entity','type=entier;index;');
		$this->add_champs('civility,lastname,firstname,job,phone,mobile,fax,email,lang,id_manager','type=chaine;');
		$this->add_champs('birthday','type=date');
		
		TAtomic::initExtraFields($this);
		
		$this->start();
		$this->_init_vars();
		
		$this->lang = DEFAULT_LANG;
		
		$this->setChild('TAddress', 'id_contact');
		$this->setChild('TContactToObject', 'id_contact');
	}
	
	function name() {
		return $this->firstname.' '.$this->lastname;
	}
	
	function gravatar($size=100, $justUrl=false) {
		return TTemplate::gravatar($this->email, $this->name(), $size, 'none', $justUrl);
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
