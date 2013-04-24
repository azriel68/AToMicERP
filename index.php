<?php

	require('inc.php');

	$db=new TPDOdb;

	$user = TAtomic::getUser($db);

	if($user->isLogged()) {
		header('location:home.php');		
	}
	else {
		
		$tbs=new TTemplateTBS;
		
		$form=new TFormCore;
		
		print $tbs->render(TAtomic::getTemplate($conf, 'login')
			,array()
			,array(
				'form'=>array(
					'login'=>$form->texte(__tr('Login'), 'login', isset($_SESSION['user']) ? $_SESSION['user']->login : '' , 30)
					,'password'=>$form->password(__tr('Password'), 'password', '' , 30)
					,'entity'=>$form->combo(__tr('Entity'), 'entiy', TCompany::getEntityForCombo($db) , -1)
					,'btsubmit'=>$form->btsubmit(__tr('sign in'), 'btsignin')
				)
				,'tpl'=>array(
					'header'=>TTemplate::header($conf)
					,'footer'=>TTemplate::footer($conf)
					,'buttons'=>TTemplate::buttons()
					,'self'=>$_SERVER['PHP_SELF']
				)
			)
		); 
		
		
	}
