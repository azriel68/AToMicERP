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
	
	$TForm=array(
		'id_entity'=>$form->combo('', 'id_entity', TEntity::getEntityForCombo($db, $user->getEntity()), $company->id_entity)
		,'name'=>$form->texte('', 'name', $company->name, 80)
		,'phone'=>$form->texte('', 'phone', $company->phone, 80)
		,'email'=>$form->texte('', 'email', $company->email, 80)
		,'web'=>$form->texte('', 'web', $company->web, 80)
		,'capital'=>$form->texte('', 'capital', $company->capital, 80)
		,'legalForm'=>$form->texte('', 'legalForm', $company->legalForm, 80)
		,'vat_intra'=>$form->texte('', 'vat_intra', $company->vat_intra, 80)
		,'vat_subject'=>$form->combo('', 'vat_subject', TDictionary::get($db, $user, $company->id_entity, 'yesno'), $company->vat_subject)
		,'customerRef'=>$form->texte('', 'customerRef', $company->customerRef, 80)
		,'supplierRef'=>$form->texte('', 'supplierRef', $company->supplierRef, 80)
		,'isCustomer'=>$form->combo('', 'isCustomer', TDictionary::get($db, $user, $company->id_entity, 'yesno'), $company->isCustomer)
		,'isSupplier'=>$form->combo('', 'isSupplier', TDictionary::get($db, $user, $company->id_entity, 'yesno'), $company->isSupplier)
		
		,'logo_input'=>$form->fichier('', 'logo_input', '', 80)
		
		,'id'=>$company->getId()
		,'dt_cre'=>$company->get_date('dt_cre')
		,'dt_maj'=>$company->get_date('dt_maj')
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
				,'tabs'=>TTemplate::tabs($conf, $user, $company, 'card')
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
