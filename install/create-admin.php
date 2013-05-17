<?php

	$password = $_REQUEST['password'] or die('password, please !');
	$companyName = $_REQUEST['company'] or die('company, please !');
	
	require('../inc.php');
	
	$db=new TPDOdb;
	
	// Company creation
	$company=new TCompany;
	$company->isEntity = 1;
	
	$company->name = $companyName;
	
	print "Entity creation : ".$company->save($db).'<br>';
	
	// User superadmin creation
	$contact = new TUser;
	$contact->isSuperadmin = 1;
	$contact->lastname = ADMIN;
	$contact->login = ADMIN;
	$contact->password = $password;
	$contact->status = 1;
	$contact->id_entity = $company->getId();
	
	print "User Creation : ".$contact->save($db).'<br>';
	
	// User association with company
	$company->id_entity = $company->getId();
	$company->addContact($contact);	
	$company->save($db);
	
	// Creation of first group
	$group=new TGroup;
	$group->code='users';
	$group->name='Users';
	$group->description='Group determinate users'; 
	$i=$group->addChild($db, 'TGroupEntity');
	$group->TGroupEntity[$i]->id_entity = $company->getId();
	
	$i = $group->addChild($db, 'TGroupUser');
	$group->TGroupUser[$i]->isAdmin=1;
	$group->TGroupUser[$i]->id_user=$contact->getId();
	
	print "User Group creation : ". $group->save($db).'<br>';
	
	// Load default data in database
	require('init-conf.php');
	require('init-dictionary.php');
	
	$db->close();
