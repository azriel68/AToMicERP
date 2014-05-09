<?php


	$conf->menu->admin[] = array(
		'name'=>'__tr(MyProfile)__'
		,'id'=>'profile'
		,'position'=>1
		,'url'=>HTTP.'modules/user/user.php?id=@id@&action=view'
		,'right'=>array('user','me','view')
		,'moduleRequire'=>array('core','dictionnary','company','contact')
	);


	$conf->menu->admin[] = array(
		'name'=>'__tr(ManageUsers)__'
		,'id'=>'MUsers'
		,'position'=>2
		,'url'=>HTTP.'modules/user/user.php'
		,'right'=>array('user','all','view')
	);
	
	$conf->menu->admin[] = array(
		'name'=>'__tr(ManageGroups)__'
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
	
	TTemplate::addTabs($conf, 'TUser', array(
		'card'=>array('label'=>'__tr(Card)__','url'=>HTTP.'modules/user/user.php?id=@id@&action=view')
		,'group'=>array('label'=>'__tr(Group)__','url'=>HTTP.'modules/user/user.php?id=@id@&action=view')
	));
	TTemplate::addTabs($conf, 'TGroup', array(
			'group'=>array('label'=>'__tr(Card)__','url'=>HTTP.'modules/user/group.php?id=@id@&action=view')
			,'usergroup'=>array('label'=>'__tr(Users)__','url'=>HTTP.'modules/user/usergroup.php?id_group=@id@')
			,'right'=>array('label'=>'__tr(Rights)__','url'=>HTTP.'modules/user/right.php?id_group=@id@')
	));
	
	
	@$conf->template->TUser->card = './template/user.html';
	
	@$conf->list->TUser->userList=array(
		'sql'=>"SELECT DISTINCT u.id,u.login, u.firstname,u.lastname FROM ".DB_PREFIX."contact u 
			INNER JOIN ".DB_PREFIX."contact_to_object cto ON (u.id = cto.id_contact)
			INNER JOIN ".DB_PREFIX."company c ON (c.id = cto.id_object AND cto.objectType = 'company')
			INNER JOIN ".DB_PREFIX."group_user gu ON (u.id = gu.id_user)
			INNER JOIN ".DB_PREFIX."group g ON (g.id=gu.id_group AND g.code='users')
			INNER JOIN ".DB_PREFIX."group_entity ge ON (ge.id_group = gu.id_group)
					WHERE ge.id_entity IN (@getEntity@)"
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
	
	@$conf->template->TGroup->card = './template/group.html';
	@$conf->template->TGroup->usergroup = './template/usergroup.html';
	@$conf->template->TGroup->right = './template/right.html';
	
	@$conf->list->TGroup->groupList=array(
		'sql'=>"SELECT DISTINCT g.id, g.name FROM ".DB_PREFIX."group g 
				LEFT JOIN ".DB_PREFIX."group_entity ge ON (g.id=ge.id_group) 
				WHERE ge.id_entity IN (@getEntity@)"
		,'param'=>array(
			'hide'=>array('id')
			,'link'=>array(
				'name'=>'<a href="?action=view&id=@id@">@name@</a>'
			)
		)
	);
	
	