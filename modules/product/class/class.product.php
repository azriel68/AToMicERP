<?
class TProduct extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'product');
		parent::add_champs('id_entity','type=entier;');
		parent::add_champs('ref, label, description','type=chaine;');
		parent::add_champs('price','type=float;');
		parent::add_champs('dt_cre,dt_fin','type=date;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		
		parent::_init_vars();
		
		$this->setChild('TPrice','id_product');
	}
}

