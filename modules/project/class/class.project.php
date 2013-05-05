<?php
class TProject extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'project');
		parent::add_champs('status,id_entity','type=entier;index;');
		parent::add_champs('name','type=chaine;');
		parent::add_champs('soldePrice','type=float;');
		
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
		parent::add_champs('id_project,rank,id_requester,point','type=entier;index;');
		parent::add_champs('weight','type=entier;');
		parent::add_champs('soldePrice','type=float;');
		parent::add_champs('description','type=text;');
		parent::add_champs('name,type,status','type=chaine;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
		
		$this->setChild('TTaskTime', 'id_task');
		
		$this->TType = array(
			'feature'=>__tr('feature')
			,'chrore'=>__tr('chrore')
			,'bug'=>__tr('bug')
			,'release'=>__tr('release')
		);
		
		$this->TStatus = array(
			'idea'=>__tr('idea')
			,'todo'=>__tr('todo')
			,'inprogress'=>__tr('inprogress')
			,'finish'=>__tr('finish')
		);
		
		$this->TPoint=array(
			0=>0
			,1=>1
			,2=>2
			,3=>3
			,5=>5
			,8=>8
		);
				
	}
}

class TTaskTime extends TObjetStd {
	function __construct() {
		parent::set_table(DB_PREFIX.'project_task_time');
		parent::add_champs('duration','type=entier;');
		parent::add_champs('id_task,id_user','type=entier;index;');
		parent::add_champs('thm','type=float;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}
class TTaskTag extends TObjetStd {
	function __construct() {
		parent::set_table(DB_PREFIX.'project_task_tag');
		parent::add_champs('id_task','type=entier;index;');
		parent::add_champs('tag','type=chaine;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}
 