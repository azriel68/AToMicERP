<?php
class TContact extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'contact');
		parent::add_champs('isUser,isAdmin,status,id_entity','type=entier;index;');

		parent::add_champs('login,password','type=chaine;index;');
		parent::add_champs('lastname,firstname,phone,fax,email,lang','type=chaine;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();

		$this->setChild('TAddress', 'id_contact');
		$this->setChild('TContactToObject', 'id_contact');

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

 