<?php

/******************************************************************************************
 * Définition du module
 ******************************************************************************************/
$conf->modules['company']=array(
	'name'=>'Company'
	,'id'=>'TCompany'
	,'class'=>array('TCompany','TEntity')
	,'folder'=>'company'
	,'icon'=>'112-group.png'
	,'moduleRequire'=>array('core','dictionnary')
);

$conf->menu->admin[] = array(
	'name'=>'__tr(MyEntity)__'
	,'id'=>'entity'
	,'position'=>2
	,'url'=>HTTP.'modules/company/company.php?id=@id@&action=view'
	,'right'=>array('user','me','view')
	,'moduleRequire'=>array('core','dictionnary','company','contact')
);


/******************************************************************************************
 * Définition des menus (top / left)
 ******************************************************************************************/

TTemplate::addMenu($conf, 'TCompany', 'Companies', HTTP.'modules/company/company.php', 'company', '', false, 1);
TTemplate::addMenu($conf, 'customer', 'Customers', HTTP.'modules/company/company.php?isCustomer=1', 'company', 'TCompany', true);
TTemplate::addMenu($conf, 'addcustomer', 'Add customer', HTTP.'modules/company/company.php?action=new&isCustomer=1', 'company', 'TCompany');
TTemplate::addMenu($conf, 'supplier', 'Suppliers', HTTP.'modules/company/company.php?isSupplier=1', 'company', 'TCompany', true);
TTemplate::addMenu($conf, 'addsupplier', 'Add supplier', HTTP.'modules/company/company.php?action=new&isSupplier=1', 'company', 'TCompany');
TTemplate::addMenu($conf, 'everyone', 'EveryCompanies', HTTP.'modules/company/company.php', 'company', 'TCompany');

/******************************************************************************************
 * Définition des onglet à afficher sur une fiche de l'objet
 ******************************************************************************************/
TTemplate::addTabs($conf,'TCompany',array(
	'card'=>array('label'=>'__tr(Card)__','url'=>HTTP.'modules/company/company.php?action=view&id=@id@')
	,'contact'=>array('label'=>'__tr(Contact)__','url'=>HTTP.'modules/contact/contact.php?id_company=@id@') // TODO move in good module
	,'address'=>array('label'=>'__tr(Address)__','url'=>HTTP.'modules/address/address.php?id_company=@id@')
));


/******************************************************************************************
 * Définition des templates à utiliser
 ******************************************************************************************/
@$conf->template->TCompany->card = ROOT.'modules/company/template/company.html';
@$conf->template->TCompany->short = ROOT.'modules/company/template/company-short.html';

/******************************************************************************************
 * Définition de la conf par défaut du module
 ******************************************************************************************/
$conf->defaultConf['company'] = array(
	'TCompany_autoref_customerRef_mask' => 'CU{00000}'
	,'TCompany_autoref_customerRef_dateField' => 'dt_cre'
	,'TCompany_autoref_supplierRef_mask' => 'SU{00000}'
	,'TCompany_autoref_supplierRef_dateField' => 'dt_cre'
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
			'name'=>'<a href="'.HTTP.'modules/company/company.php?action=view&id=@id@">@name@</a>'
		)
		,'search'=>array(
			'name'=>true
			,'phone'=>true
			,'email'=>true
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
