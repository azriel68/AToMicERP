<?php

$_FOR_SCRIPT=true;
require ('../../../inc.php');

$db=new TPDOdb;
_put($db, $conf, __get('put'));
_get($db, $conf, __get('get'));
$db->close();

function _get(&$db,&$conf, $case) {
	switch ($case) {
		case 'entities' :
			
			__out(TUser::getAvailableEntityTags($db, $_REQUEST['id_user']));

			break;
	}

}
function _put(&$db,&$conf, $case) {
	switch ($case) {
		case 'right' :
			__out(_setRight($db, $_REQUEST['id_group'], $_REQUEST['module'], $_REQUEST['submodule'], $_REQUEST['action']));

			break;
		case 'addGroup':
			__out(_add_group($db, $_REQUEST['id_group'], $_REQUEST['id_user']));
			break;
		case 'removeGroup':
			__out(_remove_group($db, $_REQUEST['id_group'], $_REQUEST['id_user']));
			
		case 'login':	
			// if login ok return 1, else 0
			$user=new TUser;
			print (int)$user->login($db, __get('login'), __get('password'), __get('id_entity',-1, 'integer'));
			
			break;
	}

}

function _add_group(&$db, $id_group, $id_user) {
	
	$gu=new TGroupUser;
	$gu->id_group = $id_group;
	$gu->id_user = $id_user;
	
	$gu->save($db);
	
	return 1;
}
function _remove_group(&$db, $id_group, $id_user) {
	
	$gu=new TGroupUser;
	//$gu->loadByGroupUser($db, $id_group, $id_user );
	
	//$gu->delete($db);
	// TODO set in class
	$db->Execute("DELETE FROM ".DB_PREFIX."group_user WHERE id_group=$id_group AND id_user=$id_user"); //flemmard !
	
	return 1;
}

function _setRight(&$db, $id_group, $module, $submodule, $action) {
	
	$group = new TGroup;
	$group->load($db, $id_group);
	$iRight = $group->hasRight($module, $submodule, $action);
	if($iRight !== false) {
		$group->TRight[$iRight]->delete($db);
		$group->save($db);
		return 'removed';
	} else {
		$group->addRight($module, $submodule, $action);
		$group->save($db);
		return 'added';
	}
}
