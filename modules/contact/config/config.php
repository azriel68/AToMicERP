<?php

/******************************************************************************************
 * Définition du module
 ******************************************************************************************/
$conf->modules['contact']=array(
	'name'=>'Contact'
	,'id'=>'contact'
	,'class'=>array('TContact', 'TContactToObject')
	,'folder'=>'contact'
	,'moduleRequire'=>array('core','dictionnary','company')
	
);

/******************************************************************************************
 * Définition des menus (top / left)
 ******************************************************************************************/

/******************************************************************************************
 * Définition des onglet à afficher sur une fiche de l'objet
 ******************************************************************************************/

TTemplate::addTabs($conf,'TContact',array(
	'card'=>array('label'=>'__tr(Card)__','url'=>'contact.php?action=view&id=@id@')
	,'company'=>array('label'=>'__tr(Company)__','url'=>'../company/company.php?id_contact=@id@')
));
/******************************************************************************************
 * Définition des templates à utiliser
 ******************************************************************************************/
@$conf->template->TContact->card = ROOT.'modules/contact/template/contact.html';
@$conf->template->TContact->short = ROOT.'modules/contact/template/contact-short.html';
@$conf->template->TContact->ContactList = ROOT.'modules/contact/template/contact-list.html';
@$conf->template->TContact->TCompanyContactList = @$conf->template->TContact->ContactList;

/******************************************************************************************
 * Définition des listes
 ******************************************************************************************/
@$conf->list->TContact->ContactList=array(
	'sql'=>"SELECT c.id, CONCAT(c.firstname, ' ', c.lastname) as name, c.phone, c.fax, c.email, c.lang FROM ".DB_PREFIX."contact c
			WHERE c.id_entity IN (@getEntity@)
			ORDER BY lastname"
	,'param'=>array(
		'title'=>array(
			'name'=>'__tr(Name)__'
			,'phone'=>'__tr(Phone)__'
			,'fax'=>'__tr(Fax)__'
			,'email'=>'__tr(Email)__'
			,'lang'=>'__tr(Lang)__'
		)
		,'hide'=>array('id')
		,'link'=>array(
			'name'=>'<a href="?action=view&id=@id@">@name@</a>'
		)
	)
);

@$conf->list->TContact->TCompanyContactList=array(
	'sql'=>"SELECT c.email as 'gravatar', c.id, CONCAT(c.firstname, ' ', c.lastname) as name, c.phone, c.fax, c.email, c.lang FROM ".DB_PREFIX."contact c
			LEFT JOIN ".DB_PREFIX."contact_to_object cto ON cto.id_contact = c.id
			WHERE cto.objectType = 'company' AND cto.id_object = @id_company@
			AND c.id_entity IN (@getEntity@)
			ORDER BY lastname"
	,'param'=>array(
		'title'=>array(
			'name'=>'__tr(Name)__'
			,'phone'=>'__tr(Phone)__'
			,'fax'=>'__tr(Fax)__'
			,'email'=>'__tr(Email)__'
			,'lang'=>'__tr(Lang)__'
		)
		,'hide'=>array('id','gravatar')
		,'link'=>array(
			'name'=>'<a href="'.HTTP.'modules/contact/contact.php?action=view&id=@id@">@name@</a>'
			,'email'=>'<a href="mailto:@email@">@email@</a>'
		)
		,'eval'=>array(
			'name'=>'TTemplate::gravatar("@gravatar@","", 30, "left") . \'@val@\' '
		)
	)
);
