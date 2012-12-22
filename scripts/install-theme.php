<?

	reqquire('../inc.php');
	
	$db=new Tdb;
	
	$tier=new TTier;
	
	createExtraFields($db, $tier , 'tier' );

	
	$db->close();
