<?
	require('../../inc.php');
	
	$project=new TProject;
	$db=new TPDOdb;
	$action = TTemplate::actions($db, $project);
	if($action!==false ) {

		if($action=='delete') {
			header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
		}

		$form=new TFormCore;
		$form->Set_typeaff($action);
		
		$TForm=array(
			'name'=>$form->texte('', 'name', $project->name, 80)
		);
		$tbs=new TTemplateTBS;
		
		print $tbs->render(TTemplate::getTemplate($conf, $project)
			,array()
			,array(
				'TProject'=>$TForm
				,'tpl'=>array(
					'header'=>TTemplate::header($conf)
					,'footer'=>TTemplate::footer($conf)
					,'menu'=>TTemplate::menu($conf, $user)
					,'buttons'=>TTemplate::buttons($user, $project, 'edit')
					,'tabs'=>TTemplate::tabs($conf, $user, $project, 'fiche')
					,'self'=>$_SERVER['PHP_SELF']
				)
			)
		); 
		
	}
	else {
		print TTemplate::liste($conf, $user, $db, $project);
	}
	
	$db->close();