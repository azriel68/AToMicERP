<?php


	$conf->menu->admin[] = array(
		'name'=>"My profile"
		,'id'=>'profile'
		,'position'=>1
		,'url'=>HTTP.'modules/user/user.php?id=@id@&action=view'
		,'right'=>array('user','me','view')
	);


	$conf->menu->admin[] = array(
		'name'=>"Manage users"
		,'id'=>'MUsers'
		,'position'=>2
		,'url'=>HTTP.'modules/user/user.php'
		,'right'=>array('user','all','view')
	);

	
	$conf->modules['user']=array(
		'name'=>'User'
		,'id'=>'TUser'
		,'class'=>array('TUser','TRight','TGroup','TGroupUser')
	);

	$conf->rigths[]=array('user','all','view');
	$conf->rigths[]=array('user','all','edit');
	$conf->rigths[]=array('user','me','view');
	$conf->rigths[]=array('user','me','edit');
	