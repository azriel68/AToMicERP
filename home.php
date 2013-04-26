<?php

	require('inc.php');

	if(!$user->isLogged()) {
		TTemplate::login();		
	}

	

	$tbs = new TTemplateTBS;
	print $tbs->render(TTemplate::getTemplate($conf, 'home')
		,array('boxe'=>TTemplate::getBoxes($conf, $user))
		,array(
			'tpl'=>array(
				'header'=>TTemplate::header($conf)
				,'footer'=>TTemplate::footer($conf)
				,'self'=>$_SERVER['PHP_SELF']
				,'menu'=>TTemplate::menu($conf, $user)
			)
		)
	); 