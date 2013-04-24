<?php

	require('inc.php');

	$db=new TPDOdb;
	
	if(isset($_REQUEST['logout'])) {
		unset($_SESSION['user']);
	}

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
					,'entity'=>$form->combo(__tr('Entity'), 'id_entity', TCompany::getEntityForCombo($db) , -1)
					,'btsubmit'=>'<a href="javascript:document.forms[\'formLogin\'].submit()" class="butAction">'.__tr('sign in').'</a>'  /*$form->btsubmit(__tr('sign in'), 'btsignin','','butAction')*/
				)
				,'tpl'=>array(
					'header'=>TTemplate::header($conf)
					,'footer'=>TTemplate::footer($conf)
					,'buttons'=>TTemplate::buttons()
					,'menu'=>TTemplate::menu($conf, $user)
					,'self'=>$_SERVER['PHP_SELF']
				)
			)
		); 
		
		
	}
