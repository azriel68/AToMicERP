<?php

class TRights extends TObjetStd {
	function __construct() { 
		parent::set_table('rights');
		parent::add_champs('module,submodule,action','type=chaine;index;');
		parent::add_champs('id_contact','type=entier;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
		
	}
}
