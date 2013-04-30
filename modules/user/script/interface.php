<?php

require ('../../../inc.php');

$get = isset($_REQUEST['get']) ? $_REQUEST['get'] : '';
$put = isset($_REQUEST['put']) ? $_REQUEST['put'] : '';

$db=new TPDOdb;
_put($db, $put);
_get($db, $get);
$db->close();

function _get(&$db, $case) {
	switch ($case) {
		case '??' :
			
			__out(_tasks($db, $_REQUEST['??'], $_REQUEST['??']));

			break;
	}

}
function _put(&$db, $case) {
	switch ($case) {
		case 'right' :
			__out(_setRight($db, $_REQUEST['id_group'], $_REQUEST['module'], $_REQUEST['submodule'], $_REQUEST['action']));

			break;
		case 'addGroup':
			__out(_add_group($db, $_REQUEST['id_group'], $_REQUEST['id_user']));
			break;
		case 'removeGroup':
			__out(_remove_group($db, $_REQUEST['id_group'], $_REQUEST['id_user']));
			
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
