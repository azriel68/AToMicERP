<?
	require('../../inc.php');
	pre($conf);
	
	$company=new TCompany;
	$db=new TPDOdb;
	actions($db, $company);
	fiche($conf, $company, TAtomic::getTemplate($conf, $company));
	
	$db->close();