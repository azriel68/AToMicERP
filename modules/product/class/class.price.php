<?php

class TPrice extends TObjetStd {
	function __construct() { 
		parent::set_table('price');
		parent::add_champs('id_product','type=entier;index;');
		parent::add_champs('price,priceHT,tva','type=float;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}

