<?php

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$db=new TPDOdb;
$planningrights=new TPlanningRights;
$planning=new TPlanning;
$planning->load($db,$_REQUEST['id_planning']);

$action = TTemplate::actions($db, $user, $planningrights);

if($action != false){
	//Actions
}
else{
	$tbs=new TTemplateTBS;
	$form=new TFormCore;
	
	$TPlanning=array(
		'select_calendar'=>$form->combo('', 'select_calendar', TRequeteCore::get_keyval_by_sql($db, "SELECT id,label FROM ".DB_PREFIX."planning WHERE id_entity = ".$user->id_entity, 'id', 'label') , $planning->id)
		,'id'=>$planning->id
	);
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $planningrights, 'admin')
		,array()
		,array(
			'planning'=>$TPlanning,
			'tpl'=>array(
				'header'=>TTemplate::header($conf)
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'self'=>$_SERVER['PHP_SELF']
				,'tabs'=>TTemplate::tabs($conf, $user, $planning, 'admin')
			)
		)
	)); 
}

$db->close();