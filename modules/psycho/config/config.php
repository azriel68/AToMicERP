<?php


	$conf->modules['psycho']=array(
		'name'=>'psycho'
		,'id'=>'TPsycho'
		,'class'=>array('TPsycho')
	);

	TAtomic::addHook($conf, 'TContact',array(
		'function'=>'hookLoad'
		,'object'=>'TPsycho'
		,'parameters'=>array()
	));


	/*
	@$conf->template->TUser->card = './template/user.html';
	
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
	
	@$conf->template->TGroup->card = './template/group.html';
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
	*/
	