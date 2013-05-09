<?php

/******************************************************************************************
 * Définition du module
 ******************************************************************************************/
$conf->modules['address']=array(
	'name'=>'Address'
	,'id'=>'TAddress'
	,'class'=>array('TAddress')
);

/******************************************************************************************
 * Définition des templates à utiliser
 ******************************************************************************************/
@$conf->template->TAddress->fiche = './template/adress.html';
@$conf->template->TAddress->companyAddressList = '../company/template/company_address.html';

/******************************************************************************************
 * Définition des listes
 ******************************************************************************************/
@$conf->list->TAddress->companyAddressList=array(
	'sql'=>"SELECT id, name, address, zip, city, country FROM ".DB_PREFIX."address WHERE id_company = @id_company@"
	,'param'=>array(
		'title'=>array(
			'name'=>'__tr(Name)__'
			,'address'=>'__tr(Address)__'
			,'zip'=>'__tr(Zip)__'
			,'city'=>'__tr(City)__'
			,'country'=>'__tr(Country)__'
		)
		,'hide'=>array('id')
		,'link'=>array(
			'name'=>'<a href="?action=view&id=@id@">@name@</a>'
		)
	)
);
