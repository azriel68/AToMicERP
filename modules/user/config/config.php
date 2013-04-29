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
	
	$conf->menu->admin[] = array(
		'name'=>"Manage groups"
		,'id'=>'MGroups'
		,'position'=>3
		,'url'=>HTTP.'modules/user/group.php'
		,'right'=>array('group','all','view')
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
	
	$conf->tabs->TContact['user']=array('label'=>'__tr(User)__','url'=>HTTP.'modules/user/user.php.php?id=@id@');
	
	$conf->tabs->TGroup['group']=array('label'=>'__tr(Card)__','url'=>HTTP.'modules/user/group.php.php?id=@id@');
	$conf->tabs->TGroup['user']=array('label'=>'__tr(Users)__','url'=>HTTP.'modules/user/user.php.php?id_group=@id@');
	
	@$conf->template->TUser->fiche = './template/user.html';
	
	@$conf->list->TUser->userList=array(
		'sql'=>"SELECT u.id, u.firstname,u.lastname,u.login FROM ".DB_PREFIX."contact u 
			LEFT JOIN ".DB_PREFIX."contactToObject c ON (u.id=c.id_user) 
			LEFT JOIN ".DB_PREFIX."company e ON (e.id=c.id_object AND objectType='TCompany')  
					WHERE e.id_entity=@user->id_entity@ AND u.isUser=1"
		,'param'=>array(
			'title'=>array(
				'firstname'=>'__tr(Firstname)__'
				,'lastname'=>'__tr(Lastname)__'
				,'login'=>'__tr(Login)__'
			)
			,'hide'=>array('id')
			,'link'=>array(
				'login'=>'<a href="?action=view&id=@id@">@name@</a>'
			)
		)
	);
	
	@$conf->template->TUser->fiche = './template/group.html';
	
	@$conf->list->TGroup->groupList=array(
		'sql'=>"SELECT g.id, g.name FROM ".DB_PREFIX."group g WHERE g.id_entity=@user->id_entity@"
		,'param'=>array(
			'hide'=>array('id')
			,'link'=>array(
				'name'=>'<a href="?action=view&id=@id@">@name@</a>'
			)
		)
	);
	
	