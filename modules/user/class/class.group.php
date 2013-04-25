<?php

class TGroup extends TObjetStd {
	function __construct() {
		parent::set_table(DB_PREFIX.'group');
		parent::add_champs('name', 'type=chaine;index;');
		parent::add_champs('description', 'type=chaine;');

		TAtomic::initExtraFields($this);

		parent::start();
		parent::_init_vars();
		
		$this->setChild('TGroupRight', 'id_group');
		$this->setChild('TGroupUser', 'id_group');
	}

}

class TGroupUser extends TObjetStd {
	function __construct() {
		parent::set_table('group_user');
		parent::add_champs('id_entity,id_group,id_user','type=entier;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}