<?
	require('../../inc.php');
	
	$task=new TProject;
	$db=new TPDOdb;
	$action = TTemplate::actions($db, $task);
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
		
		print $tbs->render(TTemplate::getTemplate($conf, $task)
			,array()
			,array(
				'task'=>$TForm
				,'tpl'=>array(
					'header'=>TTemplate::header($conf)
					,'footer'=>TTemplate::footer($conf)
					,'menu'=>TTemplate::menu($conf, $user)
					,'buttons'=>TTemplate::buttons($user, $task, 'edit')
					,'tabs'=>TTemplate::tabs($conf, $user, $task, 'fiche')
					,'self'=>$_SERVER['PHP_SELF']
				)
			)
		); 
		
	}
	else {
		$tbs=new TTemplateTBS;
		
		print $tbs->render(TTemplate::getTemplate($conf, $task, 'scrum')
			,array()
			,array(
				'tpl'=>array(
					'header'=>TTemplate::header($conf)
					,'footer'=>TTemplate::footer($conf)
					,'menu'=>TTemplate::menu($conf, $user)
					,'buttons'=>TTemplate::buttons($user, $task, 'edit')
					,'tabs'=>TTemplate::tabs($conf, $user, $task, 'fiche')
					,'self'=>$_SERVER['PHP_SELF']
				)
			)
		); 
		
	}
	
	$db->close();