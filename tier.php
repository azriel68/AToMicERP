<?
	/*
	 * front-end 
	 */

	require('inc.php');
	
	$tier=new TTier;
	$db=new Tdb;
	actions($db, $tier);
	
	print TTemplateTBS::render(TPL_TIER
		,array()
		,array(
			'tier'=>$tier->get_values()
		 )
	); 
	

	
	$db->close();