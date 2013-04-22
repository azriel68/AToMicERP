<?
class TCompany extends TObjetStd {
	function __construct() {
		$this->objectName = 'company';
		parent::set_table('company');
		parent::add_champs('name', 'type=chaine;');

		TAtomic::initExtraFields($this);

		parent::start();
		parent::_init_vars();

		$this -> setChild('TAddress', 'id_company');
		$this -> setChild('TContact', 'id_company');
	}

}
