<?php

	$_FOR_INSTALLER=true;
	require('../inc.php'); 
	 
	if(is_file('../install.lock')) exit(__tr('Installation already done'));
	
	$action=__get('action', 'installer');
	
	switch ($action) {
		case 'database-test':
			$db=new TPDOdb(DB_DRIVER, DB_DRIVER.':dbname='.__get('db_name').';host='.__get('db_host'), __get('db_user'), _get('db_user'));
			print_r($db);			
			break;
		case 'installer':
			installer($conf);
			
			break;
		
	}
	
	
	
function installer($conf) {
	
	$tbs=new TTemplateTBS;
		
	$form=new TFormCore;
	
	print __tr_view($tbs->render('installer.html'
		,array()
		,array(
			'form'=>array(
				'db_name'=>$form->texte('', 'db_name', 'atomic', 50 )
				,'db_user'=>$form->texte('', 'db_name', 'root', 50 )
				,'db_host'=>$form->texte('', 'db_host', $_SERVER['SERVER_NAME'], 50 )
				,'db_pass'=>$form->texte('', 'db_pass', '', 50 )
				,'db_prefix'=>$form->texte('', 'db_prefix', 'atom_', 50 )
				,'db_test'=>$form->bt(__tr('test database'), 'db_test','','butAction') 
			)
			,'tpl'=>array(
				'header'=>TTemplate::header($conf)
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>''
				,'self'=>$_SERVER['PHP_SELF']
			)
		)
	));
	
} 