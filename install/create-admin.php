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
	
	$contact->save($db);
	
	$company->addChild($db, 'TContactToObject_company', $contact->getId());

	$company->save($db);
	
	
//pre($company);	
	$db->close();
