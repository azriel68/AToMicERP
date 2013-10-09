<?php

	require('../config.sample.php');
	define('USE_TBS', true);
	require(COREROOT.'inc.core.php');
	require('../includes/class.atomic.php');
	require('../includes/class.template.php');
	require('../includes/fonction.php');

	if(is_file('../install.lock')) exit(__tr('Installation already done'));
	
	$user=new stdClass;
	$user->theme = DEFAULT_THEME;
	
	$conf=new stdClass;
	$conf->js=array();
	$conf->css=array();
	
	require('../config.templates.php');
	
	$etape = __get('etape', 'etape1');
	
	call_user_func('_'.$etape, $conf);
	
function _etape1($conf) {
	
	$tbs=new TTemplateTBS;
		
	$form=new TFormCore;
	
	print $tbs->render('etape1.html'
		,array()
		,array(
			'form'=>array(
				'database'=>$form->texte('', 'database', '', 50 )
				,'btsubmit'=>$form->btsubmit(__tr('Create database'), 'btcreate','','butAction') 
			)
			,'tpl'=>array(
				'header'=>TTemplate::header($conf)
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>''
				,'self'=>$_SERVER['PHP_SELF']
			)
		)
	);
	
} 