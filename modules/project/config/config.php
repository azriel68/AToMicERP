<?php

	$conf->menu->top[] = array(
		'name'=>"Project"
		,'id'=>'TProject'
		,'position'=>2
		,'url'=>HTTP.'modules/project/project.php'
	);
	

	$conf->modules['project']=array(
		'name'=>'Project'
		,'class'=>array('TProject','TTask')
	);
	
	@$conf->template->TProject->fiche = './template/project.html';
	
	$conf->list->TProject=new stdClass;
	$conf->list->TProject->index=array(
		'sql'=>"SELECT * FROM ".DB_PREFIX."project  WHERE id_entity=@user->id_entity@ ORDER BY name"
		,'param'=>array()
	);
	
	$conf->tabs->TProject=array(
		'fiche'=>array('label'=>'Fiche','url'=>'project.php?id=@id@')
		,'task'=>array('label'=>'Task','url'=>'task.php?id_project=@id@')
		,'contact'=>array('label'=>'Contact','url'=>'contact.php?id_project=@id@')
	);
	
	