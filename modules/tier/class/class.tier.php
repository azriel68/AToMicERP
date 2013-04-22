<?
class TTier extends TObjetStd {
	function __construct() { 
		parent::set_table('tier');
		//parent::add_champs('','type=entier;');
		parent::add_champs('name','type=chaine;');
		
		TAtomic::initExtraFields($this, 'tier');
		
		parent::start();
		parent::_init_vars();
		
		$this->setChild('TAddress', 'id_tier');
		$this->setChild('TContact', 'id_tier');
	}
}

