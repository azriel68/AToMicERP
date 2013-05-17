<?php

	$password = $_REQUEST['password'] or die('password, please !');
	$companyName = $_REQUEST['company'] or die('company, please !');
	
	require('../inc.php');
	
	$db=new TPDOdb;
	
	$company=new TCompany;
	$company->isEntity = 1;
	
	$company->name = $companyName;
	
	
	$contact = new TUser;
	$contact->isSuperadmin = 1;
	$contact->lastname = ADMIN;
	$contact->login = ADMIN;
	$contact->password = $password;
	$contact->status = 1;
	print "Création user : ".$contact->save($db).'<br>';
	
	$company->addContact($contact);
	
	$company->save($db);
	$company->id_entity = $company->getId();
	$company->save($db);

	print "Création de l'entité ".$company->save($db).'<br>';
	
	$group=new TGroup;
	$group->code='users';
	$group->name='Users';
	$group->description='Group determinate users'; 
	$i=$group->addChild($db, 'TGroupEntity');
	$group->TGroupEntity[$i]->id_entity = $company->getId();
	
	$i = $group->addChild($db, 'TGroupUser');
	$group->TGroupUser[$i]->isAdmin=1;
	$group->TGroupUser[$i]->id_user=$contact->getId();
	
	print "Création du Groupe Users : ". $group->save($db).'<br>';
	
	require('init-conf.php');
	require('init-dictionary.php');
	
//pre($company);	
	$db->close();
