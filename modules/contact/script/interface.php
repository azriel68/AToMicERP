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
		case 'contact' :
			
			__out(_contactList($db, $_REQUEST['id_user'], $_REQUEST['term']));

			break;
	}

}
function _put(&$db, $case) {
	switch ($case) {
		
			
			
	}

}
function _contactList(&$db, $id_user,$term='') {
	
	$user=new TUser;
	$user->load($db, $id_user);
	$sql="SELECT c.id, CONCAT(c.firstname, ' ', c.lastname) as `fullname` FROM ".DB_PREFIX."contact c
			WHERE c.id_entity IN (".$user->getEntity().") AND CONCAT(c.firstname, ' ', c.lastname) LIKE '%".$term."%' 
			ORDER BY c.lastname";
	
	$db->Execute($sql);
	
	$Tab=array();
	while($db->Get_line()) {
		$Tab[$db->Get_field('id')] = $db->Get_field('fullname');		
	}
	
	return $Tab;
}
