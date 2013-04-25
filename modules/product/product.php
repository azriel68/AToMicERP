<?
	/*
	 * front-end 
	 */

	require('../../inc.php');
	
	$product=new TProduct;
	$ATMdb=new TPDOdb;
	
	actions($db, $product);
	
	fiche($product, TTemplate::getTemplate($conf, $product));
	
	$ATMdb->close();