<?
	/*
	 * Inclusion des classes & non standart ci-après
	 */
	require('fonction.php');
	 
	require('class.requete.php'); 
	require('class.atomic.php'); 
	
	$conf = new stdClass;
	$conf->menu = new stdClass;
	$conf->menu->top = array();
	$conf->menu->left = array();
	$conf->modules = array();
	$conf->js = array();
	
	TAtomic::loadModule($conf);
	