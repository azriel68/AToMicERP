<?php

class TPrice extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'price');
		parent::add_champs('id_product','type=entier;index;');
		parent::add_champs('price_ht,quantity,packaging,discount,percentage_discount','type=float;');  // TODO price_ht -> price ?
		parent::add_champs('dt_start,dt_end','type=date;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}