<?php

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$db=new TPDOdb;
$u = new TUser;
$action = TTemplate::actions($db, $user, $u);
if($action!==false ) {

	if($action=='delete') {
		header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
	} else if($action=='save') {
		$user->entity->addContact($u);
		$user->entity->save($db);
	}

	$form=new TFormCore;
	$form->Set_typeaff($action);
	
	$TForm=array(
		'id_entity'=>$form->combo('', 'id_entity', TEntity::getEntityForCombo($db, $user->getEntity()), $u->id_entity)
		
		,'lastname'=>$form->texte('', 'lastname', $u->lastname, 80)
		,'firstname'=>$form->texte('', 'firstname', $u->firstname, 80)
		,'password'=>$form->texte('', 'password', $u->password, 80)
		,'login'=>$form->texte('', 'login', $u->login, 80)
		,'email'=>$form->texte('', 'email', $u->email, 80)
		
		,'id'=>$u->getId()
		,'gravatar'=>$u->gravatar(200)
		
	);
	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $u)
		,array(
			'button'=>TTemplate::buttons($user, $u, $action)
		)
		,array(
			'user'=>$TForm
			,'tpl'=>array(
				'header'=>TTemplate::header($conf)
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>TTemplate::tabs($conf, $user, $u, 'fiche')
				,'self'=>$_SERVER['PHP_SELF']
				,'mode'=>$action
			)
		)
	)); 
	
}
else {
	print TTemplate::liste($conf, $user, $db, $u, 'userList');
}

$db->close();