<?php
class TProject extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'project');
		parent::add_champs('status','type=entier;index;');
		parent::add_champs('name','type=chaine;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();

		$this->setChild('TTask', 'id_project');
	}
}

class TTask extends TObjetStd {
	function __construct() {
		parent::set_table(DB_PREFIX.'project_task');
		parent::add_champs('id_project,status','type=entier;index;');
		parent::add_champs('name','type=chaine;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}

 