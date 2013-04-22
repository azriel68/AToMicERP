<?php
class TAddress extends TObjetStd {
	function __construct() { 
		parent::set_table('address');
		//parent::add_champs('','type=entier;');
		parent::add_champs('name,address1,address2,cp,city','type=chaine;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}

