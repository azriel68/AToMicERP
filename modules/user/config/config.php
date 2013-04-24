<?php


	/*$conf->menu->top[] = array(
		'name'=>"Company"
		,'id'=>'TCompany'
		,'position'=>1
		,'url'=>HTTP.'modules/company/company.php'
	);*/

	
	$conf->modules['user']=array(
		'name'=>'User'
		,'id'=>'TUser'
		,'class'=>array('TUser','TRight','TGroup','TGroupUser')
	);
