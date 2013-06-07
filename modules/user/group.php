<?php

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$group = new TGroup;

$db=new TPDOdb;
$action = TTemplate::actions($db, $user, $group);
if($action!==false ) {

	if($action=='delete') {
		header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
	}

	$form=new TFormCore;
	$form->Set_typeaff($action);
	
	$TForm=array(
		'name'=>$form->texte('', 'name', $group->name, 80)
		,'description'=>$form->zonetexte('', 'description', $group->description, 80)
		
		,'id'=>$group->getId()
		
	);
	$tbs=new TTemplateTBS;
	
	$TButton = TTemplate::buttons($user, $group, $action);
	if($group->code!='') unset($TButton['delete']);
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $group)
		,array(
			'button'=>$TButton
			,'entity'=>TGroup::getEntityTags($db, $group->id)
		)
		,array(
			'group'=>$TForm
			,'user'=>$user
			,'tpl'=>array(
				'header'=>TTemplate::header($conf)
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>TTemplate::tabs($conf, $user, $group, 'card')
				,'self'=>$_SERVER['PHP_SELF']
				,'mode'=>$action
			)
		)
	)); 
	
}
else {
	print TTemplate::liste($conf, $user, $db, $group, 'groupList');
}

$db->close();