<?php


	$conf->menu->top[] = array(
		'name'=>"Company"
		,'id'=>'company'
		,'position'=>1
		,'url'=>HTTP.'modules/company/index.php'
	);

	
	$conf->modules[]=array(
		'name'=>'Société'
		,'id'=>'company'
		,'class'=>array('TCompany')
	);

	@$conf->template->company->fiche = './template/company.html';
	