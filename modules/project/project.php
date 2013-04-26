<?
	require('../../inc.php');
	
	$project=new TProject;
	$db=new TPDOdb;
	$action = TTemplate::actions($db, $user, $project);
	if($action!==false ) {

		if($action=='delete') {
			header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
		}

		$form=new TFormCore;
		$form->Set_typeaff($action);
		
		$TForm=array(
			'name'=>$form->texte('', 'name', $project->name, 80)
			,'id'=>$project->getId()
			
		);
		$tbs=new TTemplateTBS;
		
		print __tr_view( $tbs->render(TTemplate::getTemplate($conf, $project)
			,array('button'=>TTemplate::buttons($user, $project, $action))
			,array(
				'project'=>$TForm
				,'tpl'=>array(
					'header'=>TTemplate::header($conf)
					,'footer'=>TTemplate::footer($conf)
					,'menu'=>TTemplate::menu($conf, $user)
					,'tabs'=>TTemplate::tabs($conf, $user, $project, 'fiche')
					,'self'=>$_SERVER['PHP_SELF']
				)
			)
		) ); 
		
	}
	else {
		print TTemplate::liste($conf, $user, $db, $project);
	}
	
	$db->close();