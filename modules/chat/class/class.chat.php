<?
class TChat extends TObjetStd {
	function __construct() {
		
		$this->set_table(DB_PREFIX.'chat');
		
		$this->addFields('message',array('type'=>'text'));
		$this->addFields('id_entity,id_user_from,id_user_to', array('type'=>'int', 'index'=>true));

		TAtomic::initExtraFields($this);
		
		$this->start();
		$this->_init_vars();
		
	}
	
	static function get_events(&$db, &$user) {
		
		$Tmp = $db->ExecuteAsArray("SELECT message,id_user_from,id_user_to FROM ".DB_PREFIX."chat 
		WHERE 
		id_user_to IN (".$user->id.")
		AND dt_cre>='".date('Y-m-d H:i:s',time() - 60). "' ORDER BY id ASC" );
		
		$Tab=array();

		if(!empty($Tmp)) {
			$Tab['EventKey']='new-messages';
			$Tab['Data']=array();
						
		}
		
		foreach($Tmp as $row) {
			$Tab['Data'][] = array(
				'Message'=>$row->message
				,'UserFromId'=>$row->id_user_from
			);
		}
		return $Tab;
		
	}
	
	static function get_history(&$db, $user_to, $user_from, $for='-1 day') {
		$Tmp = $db->ExecuteAsArray("SELECT message,id_user_from,id_user_to FROM ".DB_PREFIX."chat 
		WHERE id_user_from IN (".$user_to.",".$user_from.") 
		AND  id_user_to IN (".$user_to.",".$user_from.")
		AND dt_cre>='".date('Y-m-d H:i:s', strtotime($for)). "' ORDER BY id ASC" );
		
		$Tab=array();
		foreach($Tmp as $row) {
			$Tab[] = array(
				'Message'=>$row->message
				,'UserFromId'=>$row->id_user_from
			);
		}
		return $Tab;
	}
	static function get_users_list(&$db, &$user){
	
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
	
}
