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
		
		print $tbs->render(TTemplate::getTemplate($conf, 'login')
			,array()
			,array(
				'form'=>array(
					'login'=>$form->texte(__tr('Login'), 'login', isset($_SESSION['user']) ? $_SESSION['user']->login : '' , 30, 255, 'onchange="fillSelectEntity(this.value)"; ')
					,'password'=>$form->password(__tr('Password'), 'password', '' , 30)
					,'id_entity'=>$form->combo(__tr('Entities'),'id_entity', TEntity::getEntityForCombo( $db ), -1  )
					,'back'=>__get('back')
					,'btsubmit'=>$form->btsubmit(__tr('sign in'), 'btlogin','','butAction') //.'<a href="javascript:document.forms[\'formLogin\'].submit()" class="butAction">'.__tr('sign in').'</a>'  /*$form->btsubmit(__tr('sign in'), 'btsignin','','butAction')*/
				)
				,'tpl'=>array(
					'header'=>TTemplate::header($conf,__tr('Sign in'), '', __val( $user->error ) )
					,'footer'=>TTemplate::footer($conf)
					,'menu'=>TTemplate::menu($conf, $user)
					,'self'=>$_SERVER['PHP_SELF']
				)
			)
		); 
		
		
	}
