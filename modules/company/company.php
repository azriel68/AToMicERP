<?
	require('../../inc.php');
	
	$company=new TCompany;
	$db=new TPDOdb;

	if($res = TTemplate::actions($db, $company) !==false ) {
		TTemplate::fiche($conf, $company, TAtomic::getTemplate($conf, $company));
		
	}
	else {
		TTemplate::liste($conf, $db, $company);
	}
	
	$db->close();