<?

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$company=new TCompany;
$db=new TPDOdb;
$action = TTemplate::actions($db, $user, $company);

if($action!==false ) {

	$successMsg='';
	if($action=='delete') {
		header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
	}
	else if($action=='save') {
		$successMsg = __tr('Company saved');
		
		// TODO if set as entity, add user group to this entity
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
		,'isEntity'=>$form->combo('', 'isEntity', TDictionary::get($db, $user, $company->id_entity, 'yesno'), $company->isEntity)
		
		,'logo_input'=>$form->fichier('', 'logo_input', '', 80)
		
		,'id'=>$company->getId()
		,'dt_cre'=>$company->get_date('dt_cre')
		,'dt_maj'=>$company->get_date('dt_maj')
	);
	$tbs=new TTemplateTBS;
	
	$TButtons = TTemplate::buttons($user, $company, $action);
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $company)
		,array(
			'button'=>$TButtons
		)
		,array(
			'company'=>$TForm
			,'user'=>$user
			,'tpl'=>array(
				'header'=>TTemplate::header($conf, __tr('Company : ').$company->name, $successMsg  )
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
}

$db->close();
