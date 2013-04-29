<?php
class TProject extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'project');
		parent::add_champs('status,id_entity','type=entier;index;');
		parent::add_champs('name','type=chaine;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();

		$this->setChild('TTask', 'id_project');
		
		$this->TStatus = array(
			0=>'Non débuté'
			,1=>'En cours'
			,2=>'En recette'
			,3=>'Terminé'
		);
	}
}

class TTask extends TObjetStd {
	function __construct() {
		parent::set_table(DB_PREFIX.'project_task');
		parent::add_champs('id_project,status','type=entier;index;');
		parent::add_champs('weight,status','type=entier;');
		parent::add_champs('name','type=chaine;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
		
		$this->setChild('TTaskTime', 'id_task');
	}
}

class TTaskTime extends TObjetStd {
	function __construct() {
		parent::set_table(DB_PREFIX.'project_task_time');
		parent::add_champs('duration','type=entier;');
		parent::add_champs('id_task','type=entier;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}
 