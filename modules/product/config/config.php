<?php


	$conf->menu->top[] = array(
		'name'=>"Produit"
		,'id'=>'product'
		,'position'=>2
		,'url'=>HTTP.'modules/product/product.php'
	);

	
	$conf->modules[]=array(
		'name'=>'Produit'
		,'id'=>'product'
		,'class'=>array('TProduct','TPrice')
	);
