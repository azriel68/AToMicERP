<?
	require('../../inc.php');
	pre($conf);
	
	$company=new TCompany;
	$db=new TPDOdb;
	actions($db, $company);
	fiche($company, TAtomic::getTemplate($conf, $company));
	
	$db->close();