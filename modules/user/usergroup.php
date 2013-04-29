<?php

	require('../../inc.php');
	
	if(!$user->isLogged()) {
		TTemplate::login();		
	}
	
	$db=new TPDOdb;
	
	$group = new TGroup;
	$group->load($db, $_REQUEST['id_group']);
	
	
	$TUserIn=array();
	$TUserOut=array();
	
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
				
			)
		)
	)); 
		
	
	$db->close();