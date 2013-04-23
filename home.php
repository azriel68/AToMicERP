<?php

	require('inc.php');

	$TBoxe=array();

	$tbs = new TTemplateTBS;
	print $tbs->render(TPL_HOME
		,array('TBoxe'=>$TBoxe)
		,array(
			'tpl'=>array(
				'header'=>_header($conf)
				,'footer'=>_footer($conf)
				,'buttons'=>_buttons()
				,'self'=>$_SERVER['PHP_SELF']
			)
		)
	); 