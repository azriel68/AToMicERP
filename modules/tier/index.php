<?
	require('../../inc.php');
	
	$tier=new TTier;
	$db=new Tdb;
	actions($db, $tier);
	fiche($tier, TAtomic::getTemplate($conf, $tier));
	
	$db->close();