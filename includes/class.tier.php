<?
class TTier extends TObjetStd {
	function __construct() { 
		parent::set_table('tier');
		//parent::add_champs('','type=entier;');
		parent::add_champs('nom','type=chaine;');
		
		initExtraFields($this, 'tier');
		
		parent::start();
		parent::_init_vars();
	}
}

