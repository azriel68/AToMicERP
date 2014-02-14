<?php

/******************************************************************************************
 * Définition du module
 ******************************************************************************************/
$conf->modules['category']=array(
	'name'=>'Category'
	,'id'=>'TCategory'
	,'class'=>array('TCategory')
	,'moduleRequire'=>array('core')
);

/******************************************************************************************
 * Définition des onglet à afficher sur une fiche de l'objet
 ******************************************************************************************/
TTemplate::addTabs($conf, 'TCompany' ,array(
	'category'=>array('label'=>'__tr(Categories)__','url'=>HTTP.'modules/category/category.php?action=view&id=@id@&object=TBill')
));

@$conf->template->TCategory->card = ROOT.'modules/category/template/category.html';
