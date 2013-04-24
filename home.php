<?php

	require('inc.php');

	if(!$user->isLogged()) {
		TTemplate::login();		
	}

	$TBoxe=array();

	$tbs = new TTemplateTBS;
	print $tbs->render(TAtomic::getTemplate($conf, 'home')
		,array('TBoxe'=>$TBoxe)
		,array(
			'tpl'=>array(
				'header'=>TTemplate::header($conf)
				,'footer'=>TTemplate::footer($conf)
				,'buttons'=>TTemplate::buttons()
				,'self'=>$_SERVER['PHP_SELF']
				,'menu'=>TTemplate::menu($conf, $user)
			)
		)
	); 