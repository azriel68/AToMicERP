<?
class TProduct extends TObjetStd {
	function __construct() { 
		parent::set_table('product');
		//parent::add_champs('','type=entier;');
		parent::add_champs('name','type=chaine;');
		
		initExtraFields($this, 'tier');
		
		parent::start();
		parent::_init_vars();
	}
}

