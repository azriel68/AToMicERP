<?php

class TUser extends TContact {
	
	function __construct() {
		
		parent::__construct();
		
		$this->setChild('TGroupUser', 'id_user');
		
		$this->t_connexion = 0;
		$this->id_entity = 0;
		$this->entity = new TCompany;
		
		$this->lang = DEFAULT_LANG;
		$this->theme = DEFAULT_THEME;
		
		$this->rights = array();
		
	}
	
	function load(&$db, $id) {
		parent::load($db, $id);
		$this->load_right($db);
		
		if(!empty($this->id_entity)) {
			$this->entity->load($db, $this->id_entity);
		}
	}
	
	function load_right(&$db) {
		foreach($this->TGroupUser as $groupUser) {
			$TRight = TRequeteCore::get_id_from_what_you_want($db, DB_PREFIX.'right', array('id_group'=>$groupUser->id_group));
			foreach($TRight as $id_right) {
				$right = new TRight;
				$right->load($db, $id_right);
				@$this->rights[$groupUser->id_entity]->{$right->module}->{$right->submodule}->{$right->action} = true;
			}
		}
	}
	
	function login (&$db, $login, $pwd, $id_entity) {
		$sql = "SELECT id FROM ".$this->get_table()." 
			WHERE login=".$db->quote($login)." AND password=".$db->quote($pwd)."
			AND status = 1";
		$db->Execute($sql);
			
		if($db->Get_line()) {
			$this->id_entity = $id_entity;
			$this->t_connexion = time();
			return $this->load($db, $db->Get_field('id'));
		}	
		else  {
			TAtomic::errorlog("ErrorBadLogin ($login $pwd)");
		}
			
		return false;
	}
	
	function isLogged() {
		
		if(!empty($_SESSION['user']) && $this->right('login') && $this->t_connexion > 0 ) {
			return true;
			
		}
		
		return false;
	}
	function getEntity($mode='sql') {
		/* retour l'entité possible en fonction de ses droits */
		$TEntity = array();
		foreach($this->rights as $id_entity=>$right) {
			$TEntity[] = $id_entity;
		}
		
		$TEntity[]=$this->id_entity;
		
		if($mode=='sql') return implode(',', $TEntity);
		else return $TEntity;
		
	}
	
	
	function right($module='main', $submodule='main', $action='view') {
		
		if(empty($submodule)) $submodule = 'main';
		
		if($this->isAdmin) return true;
		else if($module == 'login' && !empty($this->rights[$this->id_entity])) return true;
		else if(!empty($this->rights[$this->id_entity]->{$module}->{$submodule}->{$action})) return true;
		
		return false;
		
	}

}
