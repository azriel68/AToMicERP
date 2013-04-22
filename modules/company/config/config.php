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
	);

	@$conf->template->company->fiche = './template/company.html';
	