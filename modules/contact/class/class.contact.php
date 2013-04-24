<?php
class TContact extends TObjetStd {
	function __construct() { 
		parent::set_table('contact');
		parent::add_champs('isUser,isAdmin,status,id_company','type=entier;index;');
		parent::add_champs('login,password','type=chaine;index;');
		parent::add_champs('lastname,firstname,phone,fax,email,lang','type=chaine;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();

		$this->setChild('TAddress', 'id_contact');
		//$this->setChild('TContactCompany', 'id_contact');

	}
}
/*
class TContactCompany extends TObjetStd {
	function __construct() {
		parent::set_table('contact_company');
		parent::add_champs('id_contact,id_company','type=entier;index;');
		parent::add_champs('function','type=chaine;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}
 */
 