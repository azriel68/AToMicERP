<?
	/*
	 * front-end 
	 */

	require('inc.php');
	
	$tier=new TTier;
	$db=new Tdb;
	actions($db, $tier);
	fiche($tier, TPL_TIER);
	
	$db->close();