<?php

class TPrice extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'price');
		parent::add_champs('id_product','type=entier;index;');
		parent::add_champs('price,price_ht,vat_rate','type=float;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}

