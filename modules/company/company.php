<?

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$company=new TCompany;
$db=new TPDOdb;
$action = TTemplate::actions($db, $user, $company);

if($action!==false ) {

	if($action=='delete') {
		header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
	}

	$form=new TFormCore;
	$form->Set_typeaff($action);
	
	$listContact = new TListviewTBS('list_TContact');
	$sqlContact = strtr($conf->list->TContact->contactListOnCompany['sql'],array(
		'@id_company@'=>$company->getId()
	));
	
	$paramContact = $conf->list->TContact->contactListOnCompany['param'];
	
	$TForm=array(
		'name'=>$form->texte('', 'name', $company->name, 80)
		,'phone'=>$form->texte('', 'phone', $company->phone, 80)
		,'email'=>$form->texte('', 'email', $company->email, 80)
		,'web'=>$form->texte('', 'web', $company->web, 80)
		,'customerRef'=>$form->texte('', 'customerRef', $company->customerRef, 80)
		,'supplierRef'=>$form->texte('', 'supplierRef', $company->supplierRef, 80)
		,'isCustomer'=>$form->combo('', 'isCustomer', array(0=>__tr('No'), 1=>__tr('Yes')), $company->isCustomer)
		,'isSupplier'=>$form->combo('', 'isSupplier', array(0=>__tr('No'), 1=>__tr('Yes')), $company->isSupplier)
		
		,'id'=>$company->getId()
		,'dt_cre'=>$company->get_date('dt_cre')
		,'dt_maj'=>$company->get_date('dt_maj')
		
		,'contactList'=>$listContact->render($db, $sqlContact, $paramContact)
	);
	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $company)
		,array(
			'button'=>TTemplate::buttons($user, $company, $action)
		)
		,array(
			'company'=>$TForm
			,'tpl'=>array(
				'header'=>TTemplate::header($conf, __tr('Company : ').$company->name  )
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>TTemplate::tabs($conf, $user, $company, 'fiche')
				,'self'=>$_SERVER['PHP_SELF']
				,'mode'=>$action
			)
		)
	)); 
	
}
else {
	print TTemplate::liste($conf, $user, $db, $company, 'companyList');
	/*
	// Data table test
	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $company,'list')
		,array(
			'button'=>TTemplate::buttons($user, $company, 'list')
		)
		,array(
			'tpl'=>array(
				'header'=>TTemplate::header($conf)
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'http'=>HTTP
				,'self'=>$_SERVER['PHP_SELF']
				,'list'=>TTemplate::listeDataTable($conf, $user, $db, $company, 'companyListDT')
			)
		)
	));
	 * 
	 */
}

$db->close();
