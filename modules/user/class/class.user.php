<?php

class TUser extends TContact {
	
	function __construct() {
		
		parent::__construct();
		
		$this->setChild('TGroupUser', 'id_user');
		
		$this->t_connexion = 0;
		
	}
	
	function load(&$db, $id, $entity) {
		parent::load($db, $id);
		$this->load_right($db, $entity);
	}
	
	function load_right(&$db, $entity) {
		foreach($this->TGroupUser as $groupUser) {
			if($groupUser->id_entity == $entity) {
				$TRight = TRequeteCore::get_id_from_what_you_want($db, 'right', array('id_group'=>$groupUser->id_group));
				foreach($TRight as $id_right) {
					$right = new TRight;
					$right->load($db, $id_right);
					$this->rights->{$right->module}->{$right->submodule}->{$right->action} = true;
				}
			}
		}
	}
	
	function login (&$db, $login, $pwd, $entity=0) {
			
		$db->Execute("SELECT id FROM ".$this->get_table()." 
			WHERE login=".$db->quote($login)." AND password=".$db->quote($pwd))."
			AND status = 1";
			
		if($db->Get_line()) {
			
			$this->t_connexion = time();
			
			return $this->load($db, $db->Get_field('id'), $entity);
			
		}	
		/*else  {
			print "ErrorBadLogin";
		}*/
			
		return false;
	}
	
	function isLogged() {
		
		if(!empty($_SESSION['user']) && $this->t_connexion > 0 ) {
			return true;
			
		}
		
		return false;
	}
	function right($module='main', $action='view') {
		
		if($this->isAdmin) return true;
		else if(!empty($this->rights->{$module}->{$module}->{$action})) return true;
		
		return false;
		
	}
}
