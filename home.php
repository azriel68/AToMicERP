<?php

	require('inc.php');

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
			)
		)
	); 