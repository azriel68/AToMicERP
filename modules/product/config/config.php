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
	'name'=>'Products'
	,'id'=>'TProduct'
	,'position'=>2
	,'url'=>HTTP.'modules/product/product.php'
);

/******************************************************************************************
 * Définition des onglet à afficher sur une fiche de l'objet
 ******************************************************************************************/
$conf->tabs->TProduct=array(
	'fiche'=>array('label'=>'__tr(Card)__','url'=>HTTP.'modules/product/product.php?action=view&id=@id@')
	,'prices'=>array('label'=>'__tr(Price)__','url'=>HTTP.'modules/product/price.php?id_product=@id@')
);

/******************************************************************************************
 * Définition des templates à utiliser
 ******************************************************************************************/
@$conf->template->TProduct->fiche = ROOT.'modules/product/template/product.html';

/******************************************************************************************
 * Définition des listes
 ******************************************************************************************/
@$conf->list->TProduct->productList=array(
	'sql'=>"SELECT id, ref, label, description, price FROM ".DB_PREFIX."product WHERE id_entity IN (@getEntity@)"
	,'param'=>array(
		'title'=>array(
			'ref'=>'__tr(Ref)__'
			,'label'=>'__tr(Label)__'
			,'description'=>'__tr(Description)__'
			,'price'=>'__tr(Price)__'
		)
		,'hide'=>array('id')
		,'link'=>array(
			'ref'=>'<a href="?action=view&id=@id@">@ref@</a>'
		)
	)
);