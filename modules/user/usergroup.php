<?php

	require('../../inc.php');
	
	if(!$user->isLogged()) {
		TTemplate::login($user);		
	}
	
	$db=new TPDOdb;
	
	$group = new TGroup;
	$group->load($db, $_REQUEST['id_group']);
	
	$TUserIn=array();
	foreach($group->TGroupUser as $groupuser) {
		$u = new TUser;
		$u->load($db, $groupuser->id_user);
		$TUserIn[$u->getId()] = $u;
	}
	
	$TUserOut=array();
	$TUserList=TGroup::getAvailableUserList($db, $group->id);
	foreach($TUserList as $userid) {
		if(empty($TUserIn[$userid])) {
			$u = new TUser;
			$u->load($db, $userid);
			$TUserOut[$u->getId()] = $u;
		}
	}
	
	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $group, 'usergroup')
		,array(
			'userIn'=>$TUserIn
			,'userOut'=>$TUserOut
		)
		,array(
			'group'=>$group->get_values()
			,'tpl'=>array(
				'header'=>TTemplate::header($conf)
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>TTemplate::tabs($conf, $user, $group, 'usergroup')
				,'self'=>$_SERVER['PHP_SELF']
				,'http'=>HTTP
				
			)
		)
	)); 
		
	
	$db->close();