<?php

require ('../../../inc.php');

if(__get('id_user',0,'int')!=$user->id) {
	exit; // user usurpation or logout
}


$get =  __get('get', '');
$put = __get('put', '');

_put($db, $user, $put);
_get($db, $user,$get);


function _get(&$db,&$user, $case) {
	switch ($case) {
		case 'users-list' :
			__out(_get_users_list($db, $user));
			
			break;
	}

}
function _put(&$db, $case) {
	switch ($case) {
		
			
			
	}

}

function _get_users_list(&$db, &$user){
	
	$TUser = TUser::getUserList($db, $user, array($user->id));
	
	foreach($TUser as &$u) {
		
		$u->Id = $u->id;
		$u->ProfilePictureUrl = $u->gravatar(100, true);
		$u->Status = 0;
		$u->Name = $u->name();
	
		$u->Email = $u->email;
		$u->RoomId = 'chatjs-room';
		$u->Url = '';

	}
	
	return array('Users'=>$TUser);
}
