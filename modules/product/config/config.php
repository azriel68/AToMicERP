<?php


	$conf->menu->top[] = array(
		'name'=>"Product"
		,'id'=>'TProduct'
		,'position'=>2
		,'url'=>HTTP.'modules/product/product.php'
	);

	
	$conf->modules['product']=array(
		'name'=>'Product'
		,'class'=>array('TProduct','TPrice')
	);
