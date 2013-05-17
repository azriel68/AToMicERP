<?php

/******************************************************************************************
 * Définition du module
 ******************************************************************************************/
$conf->modules['product']=array(
	'name'=>'Contact'
	,'id'=>'product'
	,'class'=>array('TProduct', 'TPrice')
	,'folder'=>'product'
);

/******************************************************************************************
 * Définition des menus (top / left)
 ******************************************************************************************/
$conf->menu->top[] = array(
	'name'=>'__tr(TProduct)__'
	,'id'=>'TProduct'
	,'position'=>2
	,'url'=>HTTP.'modules/product/product.php'
);
