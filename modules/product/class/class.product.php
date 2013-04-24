<?
class TProduct extends TObjetStd {
	function __construct() { 
		parent::set_table('product');
		//parent::add_champs('','type=entier;');
		parent::add_champs('ref,label','type=chaine;');
		parent::add_champs('description','type=chaine;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		
		parent::_init_vars();
		
		$this->setChild('TPrice','id_product');
	}
}

