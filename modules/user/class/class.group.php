<?php

class TGroup extends TObjetStd {
	function __construct() {
		parent::set_table(DB_PREFIX.'group');
		parent::add_champs('name', 'type=chaine;index;');
		parent::add_champs('id_entity', 'type=entier;index;');
		parent::add_champs('description', 'type=chaine;');

		TAtomic::initExtraFields($this);

		parent::start();
		parent::_init_vars();
		
		$this->setChild('TRight', 'id_group');
		$this->setChild('TGroupUser', 'id_group');
	}
	
	function hasRight($module, $submodule, $action) {
		foreach($this->TRight as $i => $right) {
			if($right->module == $module && $right->submodule == $submodule && $right->action == $action) return $i;
		}
		return false;
	}
	
	function addRight($module, $submodule, $action) {
		
		$iLien = $this->addChild($db, 'TRight');
		if(!isset($this->TContactToObject_company[$iLien]))$this->TContactToObject_company[$iLien]=new TRight;
		$this->TRight[$iLien]->module = $module;
		$this->TRight[$iLien]->submodule = $submodule;
		$this->TRight[$iLien]->action = $action;
		
	}
}

class TGroupUser extends TObjetStd {
	function __construct() {
		parent::set_table(DB_PREFIX.'group_user');
		parent::add_champs('id_entity,id_group,id_user','type=entier;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}