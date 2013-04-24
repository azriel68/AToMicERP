<?
class TCompany extends TObjetStd {
	function __construct() {
		
		parent::set_table('company');
		
		parent::add_champs('isEntity,entity','type=entier;index;');
		parent::add_champs('name','type=chaine;');
		
		TAtomic::initExtraFields($this);

		parent::start();
		parent::_init_vars();

		$this -> setChild('TAddress', 'id_company');
		$this -> setChild('TContact', 'id_company');
	}

}
