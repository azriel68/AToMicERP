<?php

/******************************************************************************************
 * Définition du module
 ******************************************************************************************/
$conf->modules['category']=array(
	'name'=>'Category'
	,'id'=>'TCategory'
	,'class'=>array('TCategory','TCategoryLink')
	,'moduleRequire'=>array('core')
);

/******************************************************************************************
 * Définition des onglet à afficher sur une fiche de l'objet
 ******************************************************************************************/
TTemplate::addTabs($conf, 'TCompany' 
	,array(
		'category'=>array('label'=>'__tr(Categories)__'
		,'url'=>HTTP.'modules/category/category.php?action=view&id=@id@&object=TCompany'
	)
));

TTemplate::add($conf, 'TCategory','card', ROOT.'modules/category/template/category.html');

@$conf->list->TCategory->CategoryList=array(
	'sql'=>"SELECT c.id, c.label FROM ".DB_PREFIX."contact c
			WHERE c.id_entity IN (@getEntity@)
			ORDER BY label"
	,'param'=>array(
		'title'=>array(
			'label'=>'__tr(Label)__'
		)
		,'hide'=>array('id')
		,'link'=>array(
			'name'=>'<a href="?action=view&id=@id@">@name@</a>'
		)
	)
);

