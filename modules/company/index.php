<?
	require('../../inc.php');
	pre($conf);
	
	$company=new TCompany;
	$db=new TPDOdb;

	if($res = actions($db, $company) !==false ) {
		fiche($conf, $company, TAtomic::getTemplate($conf, $company));
		
	}
	else {
		liste($db, $company);
	}
	
	$db->close();