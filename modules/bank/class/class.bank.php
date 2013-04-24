<?php

class TBank extends TObjetStd {
	function __construct() { 
		parent::set_table('bank');
		parent::add_champs('id_company','type=entier;index;');
		parent::add_champs('name,description','type=chaine;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
		
	}
}
