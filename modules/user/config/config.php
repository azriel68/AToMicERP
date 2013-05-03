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
		,'class'=>array('TUser','TRight','TGroup','TGroupUser','TGroupEntity')
	);

	$conf->rights[]=array('user','all','view');
	$conf->rights[]=array('user','all','edit');
	$conf->rights[]=array('user','me','view');
	$conf->rights[]=array('user','me','edit');
	
	$conf->tabs->TUser['user']=array('label'=>'__tr(Card)__','url'=>HTTP.'modules/user/user.php?id=@id@&action=view');
	$conf->tabs->TUser['group']=array('label'=>'__tr(Group)__','url'=>HTTP.'modules/user/user.php?id=@id@&action=view');
	
	$conf->tabs->TGroup['group']=array('label'=>'__tr(Card)__','url'=>HTTP.'modules/user/group.php?id=@id@&action=view');
	$conf->tabs->TGroup['usergroup']=array('label'=>'__tr(Users)__','url'=>HTTP.'modules/user/usergroup.php?id_group=@id@');
	$conf->tabs->TGroup['right']=array('label'=>'__tr(Rights)__','url'=>HTTP.'modules/user/right.php?id_group=@id@');
	
	@$conf->template->TUser->fiche = './template/user.html';
	
	@$conf->list->TUser->userList=array(
		'sql'=>"SELECT u.id, u.firstname,u.lastname,u.login FROM ".DB_PREFIX."contact u 
			LEFT JOIN ".DB_PREFIX."contact_to_object cto ON (u.id = cto.id_contact) 
			LEFT JOIN ".DB_PREFIX."company c ON (c.id = cto.id_object AND cto.objectType = 'company')
					WHERE c.id IN (@getEntity@) AND u.isUser = 1"
		,'param'=>array(
			'title'=>array(
				'firstname'=>'__tr(Firstname)__'
				,'lastname'=>'__tr(Lastname)__'
				,'login'=>'__tr(Login)__'
			)
			,'hide'=>array('id')
			,'link'=>array(
				'login'=>'<a href="?action=view&id=@id@">@val@</a>'
			)
		)
	);
	
	@$conf->template->TGroup->fiche = './template/group.html';
	@$conf->template->TGroup->usergroup = './template/usergroup.html';
	@$conf->template->TGroup->right = './template/right.html';
	
	@$conf->list->TGroup->groupList=array(
		'sql'=>"SELECT g.id, g.name FROM ".DB_PREFIX."group g LEFT JOIN ".DB_PREFIX."group_entity ge ON (g.id=ge.id_group) WHERE ge.id_entity IN (@getEntity@)"
		,'param'=>array(
			'hide'=>array('id')
			,'link'=>array(
				'name'=>'<a href="?action=view&id=@id@">@name@</a>'
			)
		)
	);
	
	