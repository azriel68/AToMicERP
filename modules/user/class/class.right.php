<?php

class TRight extends TObjetStd {
	function __construct() { 
		parent::set_table('right');
		parent::add_champs('module,submodule,action','type=chaine;index;');
		parent::add_champs('id_group','type=entier;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}
