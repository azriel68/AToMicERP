<?
	require('../../inc.php');
	pre($conf);
	
	$company=new TCompany;
	$db=new TPDOdb;
	if($res = actions($db, $company) !==false ) {
		fiche($company, TAtomic::getTemplate($conf, $company));
		
	}
	else {
		liste($db, $company);
	}
	
	$db->close();