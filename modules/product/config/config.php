<?php

/******************************************************************************************
 * Définition du module
 ******************************************************************************************/
$conf->modules['product']=array(
	'name'=>'Product'
	,'id'=>'product'
	,'class'=>array('TProduct', 'TPrice')
	,'folder'=>'product'
	,'icon'=>'icon.png'
	,'moduleRequire'=>array('user')
);

/******************************************************************************************
 * Définition des menus (top / left)
 ******************************************************************************************/

TTemplate::addMenu($conf, 'TProduct', 'Products', HTTP.'modules/product/product.php', 'product', '','',2);

/******************************************************************************************
 * Définition des onglet à afficher sur une fiche de l'objet
 ******************************************************************************************/
TTemplate::addTabs($conf, 'TProduct', array(
	'card'=>array('label'=>'__tr(Card)__','url'=>HTTP.'modules/product/product.php?action=view&id=@id@')
	,'price'=>array('label'=>'__tr(Price)__','url'=>HTTP.'modules/product/price.php?id_product=@id@')
));
 


/******************************************************************************************
 * Définition des templates à utiliser
 ******************************************************************************************/
@$conf->template->TProduct->card = ROOT.'modules/product/template/product.html';
@$conf->template->TProduct->short = ROOT.'modules/product/template/product-short.html';
@$conf->template->TPrice->priceList = ROOT.'modules/product/template/price-list.html';
@$conf->template->TPrice->TProductPriceList = @$conf->template->TPrice->priceList;

/******************************************************************************************
 * Définition des listes
 ******************************************************************************************/
@$conf->list->TProduct->productList=array(
	'sql'=>"SELECT id, ref, label, description,price_ht FROM ".DB_PREFIX."product WHERE id_entity IN (@getEntity@)"
	,'param'=>array(
		'title'=>array(
			'ref'=>'__tr(Ref)__'
			,'label'=>'__tr(Label)__'
			,'description'=>'__tr(Description)__'
			,'price'=>'__tr(Price)__'
		)
		,'type'=>array(
			'price_ht'=>'money'
		)
		,'hide'=>array('id')
		,'link'=>array(
			'ref'=>'<a href="'.HTTP.'modules/product/product.php?action=view&id=@id@">@ref@</a>'
		)
	)
);

@$conf->list->TPrice->priceList=array(
	'sql'=>"SELECT id, price_ht, vat_rate, dt_deb, dt_fin FROM ".DB_PREFIX."price WHERE id_entity IN (@getEntity@)"
	,'param'=>array(
		'title'=>array(
			'price_ht'=>'__tr(Price)__'
			,'vat_rate'=>'__tr(Vat_rate)__'
			,'dt_deb'=>'__tr(Dt_deb)__'
			,'dt_fin'=>'__tr(Dt_fin)__'
		)
		,'hide'=>array('id')
	)
);

@$conf->list->TPrice->TProductPriceList=array(
	'sql'=>"SELECT id, price_ht, vat_rate, dt_deb, dt_fin FROM ".DB_PREFIX."price WHERE id_entity IN (@getEntity@)
			AND id_product = @id_product@"
	,'param'=>array(
		'title'=>array(
			'price_ht'=>'__tr(Price)__'
			,'vat_rate'=>'__tr(Vat_rate)__'
			,'dt_deb'=>'__tr(Dt_deb)__'
			,'dt_fin'=>'__tr(Dt_fin)__'
		)
	,'hide'=>array('id')
	)
);