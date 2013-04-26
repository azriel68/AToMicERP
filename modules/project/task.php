<?
	require('../../inc.php');
	
	if(!$user->isLogged()) {
		TTemplate::login();		
	}
	
	$task=new TProject;
	$db=new TPDOdb;
	$action = TTemplate::actions($db, $user, $task);
	if($action!==false)  {

		if($action=='delete') {
			header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
		}

		$form=new TFormCore;
		$form->Set_typeaff($action);
		
		$TForm=array(
			'name'=>$form->texte('', 'name', $task->name, 80)
		);
		$tbs=new TTemplateTBS;
		
		print __tr_view( $tbs->render(TTemplate::getTemplate($conf, $task)
			,array('button'=>TTemplate::buttons($user, $task, $action))
			,array(
				'task'=>$TForm
				,'tpl'=>array(
					'header'=>TTemplate::header($conf)
					,'footer'=>TTemplate::footer($conf)
					,'menu'=>TTemplate::menu($conf, $user)
					
					,'tabs'=>TTemplate::tabs($conf, $user, $task, 'fiche')
					,'self'=>$_SERVER['PHP_SELF']
				)
			)
		) ); 
		
	}
	else {
		$tbs=new TTemplateTBS;
		
		print __tr_view($tbs->render(TTemplate::getTemplate($conf, $task, 'scrum')
			,array('button'=>TTemplate::buttons($user, $task, $action))
			,array(
				'tpl'=>array(
					'header'=>TTemplate::header($conf)
					,'footer'=>TTemplate::footer($conf)
					,'menu'=>TTemplate::menu($conf, $user)
					,'tabs'=>TTemplate::tabs($conf, $user, $task, 'fiche')
					,'self'=>$_SERVER['PHP_SELF']
				)
			)
		)); 
		
	}
	
	$db->close();