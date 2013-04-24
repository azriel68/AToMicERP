<?php


	$conf->menu->top[] = array(
		'name'=>"Produit"
		,'id'=>'TProduct'
		,'position'=>2
		,'url'=>HTTP.'modules/product/product.php'
	);

	
	$conf->modules[]=array(
		'name'=>'Produit'
		,'id'=>'TProduct'
		,'class'=>array('TProduct','TPrice')
	);
