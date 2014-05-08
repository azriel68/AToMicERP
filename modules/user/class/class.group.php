<?php

class TGroup extends TObjetStd {
	function __construct() {
		parent::set_table(DB_PREFIX.'group');
		parent::add_champs('name,code', 'type=chaine;index;');
		parent::add_champs('id_entity', 'type=entier;index;');
		parent::add_champs('description', 'type=chaine;');

		TAtomic::initExtraFields($this);

		parent::start();
		parent::_init_vars();
		
		$this->setChild('TRight', 'id_group');
		$this->setChild('TGroupUser', 'id_group');
		$this->setChild('TGroupEntity', 'id_group');
	}
	function setEntities(&$db, $TEntity) {
		
		$result = false;
		
		foreach($TEntity as $id_entity) {
			
			if(!$this->isEntitiesAlreadyLinked($id_entity)) {
				
				 $k = $this->addChild($db, 'TGroupEntity');
				
				 $this->TGroupEntity[$k]->id_entity = $id_entity;
				
				 $result=true;
			}
			
		}
		
		if($this->deleteEntitiesLinkNotIn($TEntity)) $result=true;		
		
		return $result;
	}
	
	function isEntitiesAlreadyLinked($id_entity) {
		
		foreach($this->TGroupEntity as &$e) {
			if($e->id_entity == $id_entity) return true;
		}
		
		return false;
	}
	
	function deleteEntitiesLinkNotIn($TEntity) {
		
		$result = false;
		
		foreach($this->TGroupEntity as &$e) {
			
			if(!in_array($e->id_entity, $TEntity)) {
				
				$e->to_delete = true;
				
				$result = true;
				
			}
			
		}
		
		return $result;
		
		
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
	function loadByCode(&$db, $code, $id_entity) {
		$TId = TRequeteCore::_get_id_by_sql($db, "SELECT DISTINCT id FROM ".$this->get_table()." g LEFT JOIN ".DB_PREFIX."group_entity ge ON (ge.id_group=g.id)
		WHERE g.code='".$code."' AND ge.id_entity=".$id_entity);
		if(!empty($TId)) {
			return $this->load($db, $TId[0]);
		}
		return false;
		
	}
	function save(&$db) {
				
		parent::save($db);
		
		//TODO if no entities linked, link default from $this->id_entity 
		
	}
	
	static function getEntityTags(&$db, $idGroup) {
		
		$db->Execute("SELECT DISTINCT CONCAT(e.id,'. ',e.name) as 'tag'
		FROM ".DB_PREFIX."group_entity ge LEFT JOIN ".DB_PREFIX."company e ON (e.id=ge.id_entity)
		WHERE ge.id_group=".$idGroup);
		
		$Tab=array();
		
		while($db->Get_line()) {
			$Tab[] = $db->Get_field('tag');
		}
		
		return $Tab;
	}
}
class TGroupEntity extends TObjetStd {
	function __construct() {
		parent::set_table(DB_PREFIX.'group_entity');
		parent::add_champs('id_entity,id_group','type=entier;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
	function loadByGroupUser($db, $id_group, $id_user ){
		
		
		
	}
}
class TGroupUser extends TObjetStd {
	function __construct() {
		parent::set_table(DB_PREFIX.'group_user');
		parent::add_champs('id_group,id_user,isAdmin','type=entier;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
	
	function loadByGroupUser($db, $id_group, $id_user ){
		
		
		
	}
}