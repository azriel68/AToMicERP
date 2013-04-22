<?
	/*
	 * front-end 
	 */

	require('../../inc.php');
	
	$product=new TProduct;
	$ATMdb=new TPDOdb;
	
	actions($db, $product);
	
	fiche($product, TAtomic::getTemplate($conf, $product));
	
	$ATMdb->close();