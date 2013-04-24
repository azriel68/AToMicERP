<?php


	$conf->menu->top[] = array(
		'name'=>"Company"
		,'id'=>'TCompany'
		,'position'=>1
		,'url'=>HTTP.'modules/company/company.php'
	);

	
	$conf->modules['company']=array(
		'name'=>'Company'
		,'id'=>'TCompany'
		,'class'=>array('TCompany')
	);

	@$conf->template->TCompany->fiche = './template/company.html';
	
	@$conf->list->TCompany->index=array(
		'sql'=>"SELECT * FROM company ORDER BY name"
		,'param'=>array()
	);
