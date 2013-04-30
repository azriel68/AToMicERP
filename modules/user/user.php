<?php

	require('../../inc.php');
	
	if(!$user->isLogged()) {
		TTemplate::login();		
	}
	
	$db=new TPDOdb;
	$u = new TUser;
	$action = TTemplate::actions($db, $user, $u);
	if($action!==false ) {

		if($action=='delete') {
			header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
		} else if($action=='save') {
			$user->company->addContact($u);
			$user->company->save($db);
		}

		$form=new TFormCore;
		$form->Set_typeaff($action);
		
		$TForm=array(
			'lastname'=>$form->texte('', 'lastname', $u->lastname, 80)
			,'firstname'=>$form->texte('', 'firstname', $u->firstname, 80)
			,'password'=>$form->texte('', 'password', $u->password, 80)
			,'login'=>$form->texte('', 'login', $u->login, 80)
			
			,'id'=>$u->getId()
			
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