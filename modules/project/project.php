<?

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

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
		'id_entity'=>$form->combo('', 'id_entity', TEntity::getEntityForCombo($db, $user->getEntity()), $project->id_entity)
		,'name'=>$form->texte('', 'name', $project->name, 80)
		,'status'=>$form->combo('', 'status', $project->TStatus, $project->status)
		,'soldePrice'=>$form->texte('', 'soldePrice', $project->soldePrice, 20)
		,'dt_start'=>$form->calendrier('', 'dt_start', $project->dt_start, 10)
		,'dt_end'=>$form->calendrier('', 'dt_end', $project->dt_end, 10)
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
				,'tabs'=>TTemplate::tabs($conf, $user, $project, 'card')
				,'self'=>$_SERVER['PHP_SELF']
			)
		)
	) ); 
	
}
else {
	print TTemplate::liste($conf, $user, $db, $project, 'index',array('translate'=>array('status'=>$project->TStatus)));
}

$db->close();