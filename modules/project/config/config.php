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
	
	@$conf->list->TProject->index=array(
		'sql'=>"SELECT * FROM ".DB_PREFIX."project  WHERE entity=@user->id_entity@ ORDER BY name"
		,'param'=>array()
	);
	