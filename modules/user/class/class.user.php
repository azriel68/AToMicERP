<?php

class TUser extends TContact {
	
	function __construct() {
		
		parent::add_champs('isSuperadmin','type=entier;index;');
		parent::add_champs('login,password,UId','type=chaine;index;');
		
		parent::__construct();
		
		$this->setChild('TGroupUser', 'id_user');
		
		$this->t_connexion = 0;
		$this->id_entity_c = 0;
		$this->entity = new TCompany;
		
		$this->theme = DEFAULT_THEME;
		
		$this->rights = array();
	}
	static function checkLoginExist(&$db, $login, $TIdExclude=array()) {
		
		$db->Execute("SELECT id FROM ".DB_PREFIX."contact 
			WHERE login='".$login."' AND id NOT IN (-1,".implode(',',$TIdExclude).")");
		if($db->Get_line()) {
			return true;
		}
		else {
			return false;
		}
		
	}
	private function setUId() {
		
		if(empty($this->UId)) {
			$this->UId = md5(time().$this->login).'@'.rand(0,100000);
		}
	}
	
	function save(&$db) {
		
		if(TUser::checkLoginExist($db, $this->login, array($this->getId()) )) {
			TAtomic::errorlog('ErrorLoginAlreadyExist ('.$this->login.')');
			
			return false;
		}
		else {
			$this->setUId();
		
			return parent::save($db);
		}
	}
	
	function load(&$db, $id) {
		$res = parent::load($db, $id);
		$this->load_right($db);
		
		if(!empty($this->id_entity_c)) {
			$this->entity->load($db, $this->id_entity_c);
		}
		
		return $res;
	}
	
	function load_right(&$db) {
		foreach($this->TGroupUser as $groupUser) {
			
			
			$sql = "SELECT r.id,g.code,ge.id_entity 
			FROM ".DB_PREFIX."group g LEFT JOIN ".DB_PREFIX."group_entity ge ON (ge.id_group=g.id) 
				LEFT OUTER JOIN ".DB_PREFIX."right r ON (g.id=r.id_group)
			WHERE g.id=".$groupUser->id_group."
			";
			$db->Execute($sql);
			$TRight = $db->Get_All();
			foreach($TRight as $row) {
				$id_right = (int)$row->id;
				$code =$row->code;
				$id_entity =$row->id_entity;
				
				if($id_right>0) {
					$right = new TRight;
					$right->load($db, $id_right);
					@$this->rights[$id_entity]->{$right->module}->{$right->submodule}->{$right->action} = true;
				}
				
				if($code=='users') {
					@$this->rights[$id_entity]->isUser=true;

					if($groupUser->isAdmin==1) {
						@$this->rights[$id_entity]->isAdmin=true;
					}

				}
			}
		}
	}
	
	function login (&$db, $login, $pwd, $id_entity=0) {
		$sql = "SELECT id FROM ".$this->get_table()." 
			WHERE login=".$db->quote($login)." AND password=".$db->quote($pwd)."
			AND status = 1";
			
		$db->Execute($sql);
		
		TAtomic::accesslog('SQL '.$sql);	
			
		if($db->Get_line()) {
			TAtomic::accesslog('sign in successfull : '.$login);		
			//TODO add trigger USER_LOGIN
			$this->id_entity_c = $id_entity;
			$this->t_connexion = time();
			return $this->load($db, $db->Get_field('id'));
		}	
		else  {
			TAtomic::errorlog("ErrorBadLogin ($login $pwd)");
			$this->errorLogin = true;
			$this->error = __tr('ErrorBadLogin').' '.$login;
			
			return false;
		}
			
		return false;
	}
	function loginUId(&$db, $UId) {
		$sql = "SELECT id FROM ".$this->get_table()." 
			WHERE UId=".$db->quote($UId)."
			AND status = 1";
		$db->Execute($sql);
			
		if($db->Get_line()) {
			$this->t_connexion = time();
			return $this->load($db, $db->Get_field('id'));
		}	
		else  {
			TAtomic::errorlog("Error UID bad definition ($UId)");
			exit('Error UID bad definition ('.$UId.')');
			
		}
			
		return false;
	}
	function isLogged() {
		
		if(empty($this->login)) {
			return false;
		}
			
		else if(!empty($this->login) && $this->right($this->id_entity_c, 'login') && $this->t_connexion > 0 ) {
			return true;
			
		}
		elseif(!$this->right($this->id_entity_c, 'login')) {
			TAtomic::errorlog("Error no rights to login for (".$this->login.' / '. $this->getId()." / ".$this->id_entity_c.")");
			
			$this->error = __tr('Error no rights to login for')."(".$this->login.' / '.$this->getId()." / ".$this->id_entity_c.")";
			return false;	
		}
			
		return false;
	}
	function getEntity($mode='sql') {
		/* Return entities allowed by rights */
		$TEntity = array();
		foreach($this->rights as $id_entity=>$right) {
			$TEntity[] = $id_entity;
		}
		
		//$TEntity[]=$this->id_entity_c;
		
		if($mode=='sql') return implode(',', $TEntity);
		else return $TEntity;
		
	}
	
	/*
	 * Do current user had rights to module
	 */
	function right($id_entity, $module='main', $submodule='main', $action='view') {
		
		if(empty($submodule)) $submodule = 'main';
		
		if($this->isSuperadmin) return true;
		elseif(!empty($this->rights[$id_entity]->isAdmin)) return true;
		else if($module == 'login' && !empty($this->rights[$id_entity]->isUser)) return true;
		else if(!empty($this->rights[$id_entity]->{$module}->{$submodule}->{$action})) return true;
		
		return false;
		
	}

	static function getAvailableEntityTags(&$db, $idUser) {
		
		$db->Execute("SELECT DISTINCT CONCAT(e.id,'. ',e.name) as 'tag'
		FROM ".DB_PREFIX."group_entity ge LEFT JOIN ".DB_PREFIX."company e ON (e.id=ge.id_entity)
			LEFT JOIN ".DB_PREFIX."group_user gu ON (ge.id_group=gu.id_group)
		WHERE gu.id_user=".$idUser);
		
		$Tab=array();
		
		while($db->Get_line()) {
			$Tab[] = $db->Get_field('tag');
		}
		
		return $Tab;
	}
	
	function getMyGroup(&$db){
		//Check if unit group exist in database
		$db->Execute("SELECT g.id 
				FROM ".DB_PREFIX."group g LEFT JOIN ".DB_PREFIX."group_user gu ON (g.id = gu.id_group)
				LEFT JOIN ".DB_PREFIX."group_entity ge ON (ge.id_group = gu.id_group)
				WHERE gu.id_user = ".$this->getId()." AND code = 'unit'");
		
		//If exist return his id
		if($db->Get_line())
			return $db->Get_field('id');
		else{ //Else insert dependencies
			$TGroup = new TGroup;
			$TGroup->name = $this->login;
			$TGroup->code = "unit";
			$TGroup->id_entity = $this->getEntity("normal");
			$TGroup->description = "Group for single user ".$this->login;
			$TGroup->save($db);
			
			$TGroup_user = new TGroupUser;
			$TGroup_user->id_group = $TGroup->id;
			$TGroup_user->id_user = $this->getId();
			$TGroup_user->idAdmin = 0;
			$TGroup_user->save();
			
			$TGroup_entity = new TGroupEntity;
			$TGroup_entity->id_entity = $this->getEntity("normal");
			$TGroup_entity->id_group = $TGroup->id;
			$TGroup_entity->save($db);
			
			return $TGroup->id;
		}
		
	}
}
