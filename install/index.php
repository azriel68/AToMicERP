<?php

	$_FOR_INSTALLER=true;
	require('../inc.php'); 
	 
	if(is_file('../install.lock')) exit(__tr('Installation already done'));
	
	$action=__get('action', 'installer');
	
	switch ($action) {
		case 'database-test':
			$db=new TPDOdb(DB_DRIVER, DB_DRIVER.':dbname='.__get('db_name').';host='.__get('db_host'), __get('db_user'), __get('db_pass'));
			
			installer($conf, $db->error, 2);	
			break;
		case 'create-config':	
			
			$res = file_put_contents(ROOT.'config.php'
				,strtr(
					file_get_contents(
						ROOT.'config.sample.php'
					)
					,array(
						'@DB_HOSTNAME@'=>__get('db_host')
						,'@DB_BASENAME@'=>__get('db_name')
						,'@DB_USER@'=>__get('db_user')
						,'@DB_USER_PASSWORD@'=>__get('db_pass')
						,'@DB_PREFIX@'=>__get('db_prefix', 'atom_', 'string', 10)
						,'@HTTP@'=>'http://'.$_SERVER['HTTP_HOST'].substr( dirname( $_SERVER['REQUEST_URI'] ) , 0, -7)
					)
				)
			);
			
			
			installer($conf, !$res ? __tr("can't create config file") : ''  , 4);
			break;
		case 'database-create':
			
			
			$db=new TPDOdb(DB_DRIVER, DB_DRIVER.':dbname='.__get('db_name').';host='.__get('db_host'), __get('db_user'), __get('db_pass'));
			TAtomic::createMajBase($db, $conf);
			
			installer($conf, $db->error, 3);	
				
			break;
		case 'installer':
			installer($conf);
			
			break;
		
	}
	
	
	
function installer($conf, $errorMessage='', $step=1) {
	
	$tbs=new TTemplateTBS;
		
	$form=new TFormCore;
	
	print __tr_view($tbs->render('installer.html'
		,array()
		,array(
			'step1'=>array(
				'db_name'=>$form->texte('', 'db_name', __get('db_name', 'atomic', 'string', 50), 50 )
				,'db_user'=>$form->texte('', 'db_user',  __get('db_user', 'root', 'string', 50), 50 )
				,'db_host'=>$form->texte('', 'db_host',  __get('db_host', $_SERVER['SERVER_NAME'], 'string', 50), 50 )
				,'db_pass'=>$form->texte('', 'db_pass',  __get('db_pass', '', 'string', 50), 50 )
				,'db_prefix'=>$form->texte('', 'db_prefix',  __get('db_prefix', 'atom_', 'string', 10), 50 )
				,'db_test'=>$form->btsubmit(__tr('test database'), 'db_test','','butAction') 
				,'errorMessage'=>(($step==1) ? $errorMessage : '')
			)
			,'step2'=>array(
				'db_name'=>$form->hidden( 'db_name', __get('db_name', 'atomic', 'string', 50), 50 )
				,'db_user'=>$form->hidden( 'db_user',  __get('db_user', 'root', 'string', 50), 50 )
				,'db_host'=>$form->hidden( 'db_host',  __get('db_host', $_SERVER['SERVER_NAME'], 'string', 50), 50 )
				,'db_pass'=>$form->hidden( 'db_pass',  __get('db_pass', '', 'string', 50), 50 )
				,'db_prefix'=>$form->hidden( 'db_prefix',  __get('db_prefix', 'atom_', 'string', 50), 50 )
				,'db_create'=>$form->btsubmit(__tr('create config'), 'db_create','','butAction') 
				,'errorMessage'=>(($step==3) ? $errorMessage : '')
			)
			,'step3'=>array(
				'db_name'=>$form->hidden( 'db_name', __get('db_name', 'atomic', 'string', 50), 50 )
				,'db_user'=>$form->hidden( 'db_user',  __get('db_user', 'root', 'string', 50), 50 )
				,'db_host'=>$form->hidden( 'db_host',  __get('db_host', $_SERVER['SERVER_NAME'], 'string', 50), 50 )
				,'db_pass'=>$form->hidden( 'db_pass',  __get('db_pass', '', 'string', 50), 50 )
				,'db_prefix'=>$form->hidden( 'db_prefix',  __get('db_prefix', 'atom_', 'string', 50), 50 )
				,'db_create'=>$form->btsubmit(__tr('create database'), 'db_create','','butAction') 
				,'errorMessage'=>(($step==3) ? $errorMessage : '')
			)
			,'tpl'=>array(
				'header'=>TTemplate::header($conf,'Installer')
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>''
				,'self'=>$_SERVER['PHP_SELF']
			)
		)
	));
	
} 