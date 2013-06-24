<?php

/******************************************************************************************
 * Définition du module
 ******************************************************************************************/
$conf->modules['photo']=array(
	'name'=>'Photo'
	,'id'=>'photo'
	,'class'=>array('TPhoto')
	
);

/******************************************************************************************
 * Définition des onglet à afficher sur une fiche de l'objet
 ******************************************************************************************/
TTemplate::addTabs($conf, 'TProduct', array(
	'photo'=>array(
		'label'=>'__tr(Photo)__'
		,'url'=>HTTP.'modules/photo/photo.php?id_product=@id@'
		,'rank'=>3
	)
));


/******************************************************************************************
 * Définition des templates à utiliser
 ******************************************************************************************/
@$conf->template->TPhoto->card = ROOT.'modules/photo/template/photo.html';
@$conf->template->TPhoto->list = ROOT.'modules/photo/template/list.html';

/******************************************************************************************
 * Définition des listes
 ******************************************************************************************/
@$conf->list->TPhoto->list=array(
	'sql'=>"SELECT id, title, 'image',source,legend, description FROM ".DB_PREFIX."photo WHERE 1"
	,'param'=>array(
		'title'=>array(
			'title'=>'__tr(Title)__'
			,'source'=>'__tr(Source)__'
			,'description'=>'__tr(Description)__'
			,'legend'=>'__tr(Legend)__'
		)
		,'hide'=>array('id')
		,'link'=>array(
			'title'=>'<a href="?action=view&id=@id@">@val@</a>'
			,'image'=>'<img src="'.HTTP.'modules/photo/get.php?id=@id@&w=100&h=100">'
			
		)
	)
);
