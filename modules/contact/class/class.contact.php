<?php
class TContact extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'contact');
		parent::add_champs('status,id_entity','type=entier;index;');

		parent::add_champs('lastname,firstname,phone,fax,email,lang','type=chaine;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();

		$this->setChild('TAddress', 'id_contact');
		$this->setChild('TContactToObject', 'id_contact');

	}
	
	function name() {
		return $this->firstname.' '.$this->lastname;
	}
	
	function gravatar($size=100) {
		$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->email ) ) ) . "?s=" . $size;
		return '<img src="'.$grav_url.'" alt="'.$this->name().'" />';
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

 