<?
	require('../../inc.php');
	
	$company=new TTCompany;
	$db=new TPDOdb;
	actions($db, $company);
	fiche($company, TAtomic::getTemplate($conf, $company));
	
	$db->close();