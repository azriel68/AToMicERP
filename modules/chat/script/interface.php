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
			
		case 'events' :
			__out(array());
			break;
			
		case 'message-history':
			__out(array(
				'Messages'=>array()
			));
			
			break;
	}

}
function _put(&$db, &$user,$case) {
	switch ($case) {
		case 'ping':
			// tell who typing to otherUserId
			
			
			break;
		case 'send-message':
			//otherUserId=2&message=test+2&clientGuid=c55c86ef-06bd-a1ce-7fb3-32a35ba577ad
			
			break;	
		case 'start-polling':
			var_dump($user);
			$user->chat_last_connection = time();
			$user->save($db);
			
			__out(array(
				'Events'=>array()
			));
			
			break;	
	}

}

function _get_users_list(&$db, &$user){
	
	$TUser = TUser::getUserList($db, $user, array($user->id));
	
	foreach($TUser as &$u) {
		
		$u->Id = $u->id;
		$u->ProfilePictureUrl = $u->gravatar(25, true);
		$u->Status = ($u->chat_last_connection + 60 > time() ) ? 1 : 0;
		$u->Name = $u->name();
	
		$u->Email = $u->email;
		$u->RoomId = 'chatjs-room';
		$u->Url = '';

	}
	
	return array('Users'=>$TUser);
}
