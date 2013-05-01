<?php

	require('inc.php');

	if(!$user->isLogged()) {
		TTemplate::login($user);		
	}

	

	$tbs = new TTemplateTBS;
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, 'home')
		,array('boxe'=>TTemplate::getBoxes($conf, $user))
		,array(
			'tpl'=>array(
				'header'=>TTemplate::header($conf)
				,'footer'=>TTemplate::footer($conf)
				,'self'=>$_SERVER['PHP_SELF']
				,'menu'=>TTemplate::menu($conf, $user)
			)
		)
	)); 