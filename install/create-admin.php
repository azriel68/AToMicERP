<?php

	$password = $_REQUEST['password'] or die('password, please !');
	$companyName = $_REQUEST['company'] or die('company, please !');
	
	require('../inc.php');
	
	$db=new TPDOdb;
	
	$company=new TCompany;
	$company->isEntity = 1;
	
	$company->name = $companyName;
	
	$i = $company->addChild($db, 'TContact');
	
	$company->TContact[$i]->isUser = 1;
	$company->TContact[$i]->isAdmin = 1;

	$company->TContact[$i]->lastname = ADMIN;
	$company->TContact[$i]->login = ADMIN;
	$company->TContact[$i]->password = $password;
	$company->TContact[$i]->status = 1;

	$company->save($db);
	
	
//pre($company);	
	$db->close();
