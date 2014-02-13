<?
class TModule extends TObjetStd {

	function __construct() {
		
		parent::set_table(DB_PREFIX.'module');
		
		parent::add_champs('id_entity,activate','type=entier;index;');
		parent::add_champs('module','type=chaine;');
		
		TAtomic::initExtraFields($this);

		parent::start();
		parent::_init_vars();
	}

}