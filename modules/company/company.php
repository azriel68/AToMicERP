<?
	require('../../inc.php');
	
	$company=new TCompany;
	$db=new TPDOdb;

	if($res = TTemplate::actions($db, $company) !==false ) {
		TTemplate::fiche($conf, $company, TAtomic::getTemplate($conf, $company));
		
	}
	else {
		print TTemplate::liste($conf, $user, $db, $company);
	}
	
	$db->close();