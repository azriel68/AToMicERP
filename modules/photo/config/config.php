<?php

/******************************************************************************************
 * Définition du module
 ******************************************************************************************/
$conf->modules['photo']=array(
	'name'=>'Photo'
	,'id'=>'photo'
	,'class'=>array('TPhoto')
	,'folder'=>'photo'
);

/******************************************************************************************
 * Définition des onglet à afficher sur une fiche de l'objet
 ******************************************************************************************/
$conf->tabs->TProduct['photo']=array(
	'label'=>'__tr(Card)__','url'=>HTTP.'modules/product/product.php?action=view&id=@id@'
);

/******************************************************************************************
 * Définition des templates à utiliser
 ******************************************************************************************/
@$conf->template->TProduct->photo = ROOT.'modules/photo/template/photo.html';

/******************************************************************************************
 * Définition des listes
 ******************************************************************************************/
@$conf->list->TPhoto->list=array(
	'sql'=>"SELECT id, ref, label, description, price FROM ".DB_PREFIX."photo WHERE id_entity IN (@getEntity@)"
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
