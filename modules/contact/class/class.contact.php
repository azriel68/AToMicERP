<?php
class TContact extends TObjetStd {
	function __construct() { 
		parent::set_table('contact');
		//parent::add_champs('','type=entier;');
		parent::add_champs('name,firstname,phone1,phone2,fax','type=chaine;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}

