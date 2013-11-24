<?php

	$conf->menu->top[] = array(
		'name'=>"Project"
		,'id'=>'TProject'
		,'position'=>4
		,'url'=>HTTP.'modules/project/project.php'
		,'module'=>'project'
		
	);
	

	$conf->modules['project']=array(
		'name'=>'Projects'
		,'class'=>array('TProject','TTask','TTaskTime','TTaskTag')
		,'icon'=>'41-picture-frame.png'
		,'moduleRequire'=>array('user')
	);
	
	@$conf->template->TProject->card = './template/project.html';
	@$conf->template->TProject->scrum = './template/scrum.html';
	
	$conf->list->TProject=new stdClass;
	$conf->list->TProject->index=array(
		'sql'=>"SELECT id,name,status FROM ".DB_PREFIX."project  WHERE id_entity IN (@getEntity@)"
		,'param'=>array(
			'type'=>array('dt_cre'=>'date', 'dt_maj'=>'date')
			,'link'=>array('name'=>'<a href="'.HTTP.'modules/project/project.php?id=@id@&action=view">@val@</a>')
			,'hide'=>array('id')
			
		)
	);
	
	TTemplate::addTabs($conf, 	'TProject',array(
		'card'=>array('label'=>'Fiche','url'=>'project.php?id=@id@&action=view')
		,'task'=>array('label'=>'Task','url'=>'task.php?id_project=@id@')
		,'contact'=>array('label'=>'Contact','url'=>'contact.php?id_project=@id@')
	));
	
	