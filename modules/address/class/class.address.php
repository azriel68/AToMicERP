<?php
class TAddress extends TObjetStd {
	function __construct() { 
		parent::set_table('address');
		//parent::add_champs('','type=entier;');
		parent::add_champs('name,address,zip,city','type=chaine;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}

