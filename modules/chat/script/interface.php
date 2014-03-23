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
			__out(TChat::get_users_list($db, $user));
			
			break;
			
		case 'events' :
			
			__out(array('Events'=>array(TChat::get_events($db, $user))));
			
			$user->chat_last_connection = time(); /* keep alive the current user */
			$user->save($db);
			
			
			break;
			
		case 'message-history':
			__out(array(
				'Messages'=>TChat::get_history($db, $user->id, __get('otherUserId',0,'int'))
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
			$chat=new TChat;
			$chat->id_user_from = $user->id;
			$chat->id_user_to = __get('otherUserId',0,'int');
			$chat->message = __get('message','','string',256);
			$chat->id_entity = $user->id_entity;
			$chat->save($db);
			
			break;	
	}

}

