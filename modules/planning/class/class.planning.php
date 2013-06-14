<?php
class TPlanning extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'planning');
		parent::add_champs('id_entity','type=entier;');
		parent::add_champs('label','type=chaine;');
		parent::add_champs('dt_cre,dt_fin','type=date;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		
		parent::_init_vars();
	}
}