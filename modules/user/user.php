<?php

	require('../../inc.php');
	
	if(!$user->isLogged()) {
		TTemplate::login();		
	}
	
	$db=new TPDOdb;
	$action = TTemplate::actions($db, $user, $user);
	if($action!==false ) {

		if($action=='delete') {
			header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
		}

		$form=new TFormCore;
		$form->Set_typeaff($action);
		
		$TForm=array(
			'lastname'=>$form->texte('', 'lastname', $user->lastname, 80)
			,'firstname'=>$form->texte('', 'lastname', $user->firstname, 80)
			,'password'=>$form->texte('', 'lastname', $user->password, 80)
			,'login'=>$form->texte('', 'login', $user->login, 80)
			
			,'id'=>$user->getId()
			
		);
		$tbs=new TTemplateTBS;
		
		print __tr_view($tbs->render(TTemplate::getTemplate($conf, $user)
			,array(
				'button'=>TTemplate::buttons($user, $user, $action)
			)
			,array(
				'user'=>$TForm
				,'tpl'=>array(
					'header'=>TTemplate::header($conf)
					,'footer'=>TTemplate::footer($conf)
					,'menu'=>TTemplate::menu($conf, $user)
					,'tabs'=>TTemplate::tabs($conf, $user, $user, 'fiche')
					,'self'=>$_SERVER['PHP_SELF']
					,'mode'=>$action
				)
			)
		)); 
		
	}
	else {
		print TTemplate::liste($conf, $user, $db, $user, 'userList');
	}
	
	$db->close();