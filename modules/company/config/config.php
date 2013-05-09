<?php

/******************************************************************************************
 * Définition du module
 ******************************************************************************************/
$conf->modules['company']=array(
	'name'=>'Company'
	,'id'=>'TCompany'
	,'class'=>array('TCompany')
);

/******************************************************************************************
 * Définition des menus (top / left)
 ******************************************************************************************/
$conf->menu->top[] = array(
	'name'=>"Company"
	,'id'=>'TCompany'
	,'position'=>1
	,'url'=>HTTP.'modules/company/company.php'
);

/******************************************************************************************
 * Définition des onglet à afficher sur une fiche de l'objet
 ******************************************************************************************/
$conf->tabs->TCompany=array(
	'fiche'=>array('label'=>'__tr(Card)__','url'=>'company.php?action=view&id=@id@')
	,'contact'=>array('label'=>'__tr(Contact)__','url'=>'contact.php?id_company=@id@')
	,'address'=>array('label'=>'__tr(Address)__','url'=>'address.php?id_company=@id@')
);

/******************************************************************************************
 * Définition des templates à utiliser
 ******************************************************************************************/
@$conf->template->TCompany->fiche = './template/company.html';

/******************************************************************************************
 * Définition des références automatiques
 ******************************************************************************************/
@$conf->autoref->TCompany = array(
	array('field' => 'customerRef', 'mask' => 'CL{yy}{0000}', 'dateField' => 'dt_cre')
	,array('field' => 'supplierRef', 'mask' => 'FO{yy}{0000}', 'dateField' => 'dt_cre')
);

/******************************************************************************************
 * Définition des listes
 ******************************************************************************************/
@$conf->list->TCompany->companyList=array(
	'sql'=>"SELECT id, name, phone, email, web FROM ".DB_PREFIX."company WHERE id_entity IN (@getEntity@)"
	,'param'=>array(
		'title'=>array(
			'name'=>'__tr(Name)__'
			,'phone'=>'__tr(Phone)__'
			,'email'=>'__tr(Email)__'
			,'web'=>'__tr(Web)__'
		)
		,'hide'=>array('id')
		,'link'=>array(
			'name'=>'<a href="?action=view&id=@id@">@name@</a>'
		)
	)
);

// Test datatable
@$conf->list->TCompany->companyListDT=array(
	'sql'=>"SELECT SQL_CALC_FOUND_ROWS id, name, phone, email, web FROM ".DB_PREFIX."company WHERE id_entity=@user->id_entity@"
	,'columns'=>array('id', 'name', 'phone', 'email', 'web')
	,'header'=>array(
		array('name'=>'id', 'title' => 'ID')
		,array('name'=>'name', 'title' => '__tr(Name)__')
		,array('name'=>'phone', 'title' => '__tr(Phone)__')
		,array('name'=>'email', 'title' => '__tr(Email)__')
		,array('name'=>'web', 'title' => '__tr(Web)__')
	)
	,'where'=>'WHERE id_entity=@user->id_entity@'
	,'param'=>array(
		'title'=>array(
			'name'=>'__tr(Name)__'
			,'phone'=>'__tr(Phone)__'
			,'email'=>'__tr(Email)__'
			,'web'=>'__tr(Web)__'
		)
		,'hide'=>array('id')
		,'link'=>array(
			'name'=>'<a href="?action=view&id=@id@">@name@</a>'
		)
	)
);
