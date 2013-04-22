<?

	require('../inc.php');
	
	$db=new Tdb;
	
	$company=new TCompany;
	
	createExtraFields($db, $company , 'company' );

	
	$db->close();
