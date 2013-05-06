<?
	require('../../inc.php');
	
	if(!$user->isLogged()) {
		TTemplate::login($user);		
	}
	
	$db=new TPDOdb;
	$project=new TProject;
	$project->load($db, $_REQUEST['id_project']);
	
	$task=new TTask;
	
	$action = TTemplate::actions($db, $conf, $user, $task);
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
		
		print __tr_view($tbs->render(TTemplate::getTemplate($conf, $project, 'scrum')
			,array(
				'button'=>TTemplate::buttons($user, $project, $action)
				,'type'=>$task->TType
				,'status'=>$task->TStatus
				,'point'=>$task->TPoint
			)
			,array(
				'project'=>$project
				,'tpl'=>array(
					'header'=>TTemplate::header($conf)
					,'footer'=>TTemplate::footer($conf)
					,'menu'=>TTemplate::menu($conf, $user)
					,'tabs'=>TTemplate::tabs($conf, $user, $project, 'task')
					,'self'=>$_SERVER['PHP_SELF']
				)
			)
		)); 
		
	}
	
	$db->close();