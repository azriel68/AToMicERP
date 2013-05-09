<?php

class TAddress extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'address');
		parent::add_champs('id_contact,id_company','type=entier;index;');
		parent::add_champs('name,address,zip,city,country','type=chaine;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}

