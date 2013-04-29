<?php

	$conf->menu->top[] = array(
		'name'=>"Project"
		,'id'=>'TProject'
		,'position'=>4
		,'url'=>HTTP.'modules/project/project.php'
	);
	

	$conf->modules['project']=array(
		'name'=>'Project'
		,'class'=>array('TProject','TTask','TTaskTime')
	);
	
	@$conf->template->TProject->fiche = './template/project.html';
	@$conf->template->TProject->scrum = './template/scrum.html';
	
	$conf->list->TProject=new stdClass;
	$conf->list->TProject->index=array(
		'sql'=>"SELECT id,name,status FROM ".DB_PREFIX."project  WHERE id_entity=@user->id_entity@"
		,'param'=>array(
			'type'=>array('dt_cre'=>'date', 'dt_maj'=>'date')
			,'link'=>array('name'=>'<a href="?id=@id@&action=view">@val@</a>')
			,'hide'=>array('id')
			
		)
	);
	
	$conf->tabs->TProject=array(
		'fiche'=>array('label'=>'Fiche','url'=>'project.php?id=@id@')
		,'task'=>array('label'=>'Task','url'=>'task.php?id_project=@id@')
		,'contact'=>array('label'=>'Contact','url'=>'contact.php?id_project=@id@')
	);
	
	