<?php

	$password = $_REQUEST['password'] or die('password, please !');
	$companyName = $_REQUEST['company'] or die('company, please !');
	
	require('../inc.php');
	
	$db=new TPDOdb;
	
	$company=new TCompany;
	$company->isEntity = 1;
	
	$company->name = $companyName;
	
	
	$contact = new TContact;
	$contact->isUser = 1;
	$contact->isAdmin = 1;

	$contact->lastname = ADMIN;
	$contact->login = ADMIN;
	$contact->password = $password;
	$contact->status = 1;
	print "Création contact : ".$contact->save($db).'<br>';
	
	$company->addContact($contact);
	
	$company->save($db);
	$company->id_entity = $company->getId();
	$company->save($db);
	
//pre($company);	
	$db->close();
