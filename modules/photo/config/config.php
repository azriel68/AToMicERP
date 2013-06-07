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
TTemplate::addTabs($conf, 'TProduct', array(
	'photo'=>array(
		'label'=>'__tr(Photo)__'
		,'url'=>HTTP.'modules/photo/photo.php?action=view&id_product=@id@'
		,'rank'=>3
	)
));


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
