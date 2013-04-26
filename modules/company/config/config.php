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
	
	@$conf->list->TCompany->companyList=array(
		'sql'=>"SELECT name, phone, email, web FROM ".DB_PREFIX."company WHERE id_entity=@user->id_entity@ ORDER BY name"
		,'param'=>array(
			'title'=>array(
				'name'=>__tr('Name')
				,'phone'=>__tr('Phone')
				,'email'=>__tr('Email')
				,'web'=>__tr('Web')
			)
		)
	);
