<?php

class TGroup extends TObjetStd {
	function __construct() {
		parent::set_table('group');
		parent::add_champs('name', 'type=chaine;index;');
		parent::add_champs('description', 'type=chaine;');

		TAtomic::initExtraFields($this);

		parent::start();
		parent::_init_vars();
		
		$this->setChild('TGroupRight', 'id_group');
	}

}

class TGroupRight extends TObjetStd {
	function __construct() {
		parent::set_table('group_right');
		parent::add_champs('id_group,id_right','type=entier;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}
