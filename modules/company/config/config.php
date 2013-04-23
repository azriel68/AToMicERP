<?php


	$conf->menu->top[] = array(
		'name'=>"Company"
		,'id'=>'company'
		,'position'=>1
		,'url'=>HTTP.'modules/company/company.php'
	);

	
	$conf->modules[]=array(
		'name'=>'Société'
		,'id'=>'company'
		,'class'=>array('TCompany')
	);

	@$conf->template->TCompany->fiche = './template/company.html';
	
	@$conf->list->TCompany->index=array(
		'sql'=>"SELECT * FROM company ORDER BY name"
		,'param'=>array()
	);
