<?
	/*
	 * Inclusion des classes & non standart ci-après
	 */
	require('fonction.php');
	 
	require('class.requete.php'); 
	require('class.atomic.php'); 
	require('class.template.php'); 
	
	
	
	TAtomic::loadModule($conf);
	TAtomic::sortMenu($conf);
	