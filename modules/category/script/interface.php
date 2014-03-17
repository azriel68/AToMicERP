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
		case 'category' :
			
			__out(_categoryList($db, $user, __get('term','','string',30) ));

			break;
	}

}
function _put(&$db, $case) {
	switch ($case) {
		
			
			
	}

}
function _categoryList(&$db, $user,$term='') {
	
	$sql="SELECT c.id, c.label FROM ".DB_PREFIX."category c
			WHERE c.id_entity IN (".$user->getEntity().") AND label LIKE ".$db->quote('%'.$term.'%')."   
			ORDER BY c.lastname";
	
	$db->Execute($sql);
	
	$Tab=array();
	while($db->Get_line()) {
		$Tab[$db->Get_field('id')] = $db->Get_field('label');		
	}
	
	return $Tab;
}
