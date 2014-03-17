<?php

require ('../../../inc.php');

if(__get('id_user',0,'int')!=$user->id) {
	exit; // user usurpation or logout
}


$get =  __get('get', '');
$put = __get('put', '');

_put($db, $put);
_get($db, $get);


function _get(&$db, $case) {
	switch ($case) {
		case 'contact' :
			
			__out(_contactList($db, __get('id_user',0,'int'), __get('term','','string',30) ));

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
	$sql="SELECT c.id, CONCAT(c.id,'. ',c.firstname, ' ', c.lastname) as `fullname` FROM ".DB_PREFIX."contact c
			WHERE c.id_entity IN (".$user->getEntity().") AND CONCAT(c.firstname, ' ', c.lastname) LIKE ".$db->quote('%'.$term.'%')."   
			ORDER BY c.lastname";
	
	$db->Execute($sql);
	
	$Tab=array();
	while($db->Get_line()) {
		$Tab[$db->Get_field('id')] = $db->Get_field('fullname');		
	}
	
	return $Tab;
}
