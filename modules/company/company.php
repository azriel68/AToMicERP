<?
	require('../../inc.php');
	
	$company=new TCompany;
	$db=new TPDOdb;
	$action = TTemplate::actions($db, $company);
	if($action!==false ) {

		if($action=='delete') {
			header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
		}

		$form=new TFormCore;
		$form->Set_typeaff($action);
		
		$TForm=array(
			'name'=>$form->texte('', 'name', $company->name, 80)
			,'phone'=>$form->texte('', 'phone', $company->phone, 80)
			,'email'=>$form->texte('', 'email', $company->email, 80)
			,'web'=>$form->texte('', 'web', $company->web, 80)
			
			,'id'=>$company->getId()
			,'id_entity'=>$user->id_entity
			,'dt_cre'=>$company->get_date('dt_cre')
			,'dt_maj'=>$company->get_date('dt_maj')
		);
		$tbs=new TTemplateTBS;
		
		print $tbs->render(TTemplate::getTemplate($conf, $company)
			,array(
				'button'=>TTemplate::buttons($user, $company, $action)
			)
			,array(
				'company'=>$TForm
				,'tpl'=>array(
					'header'=>TTemplate::header($conf)
					,'footer'=>TTemplate::footer($conf)
					,'menu'=>TTemplate::menu($conf, $user)
					,'tabs'=>TTemplate::tabs($conf, $user, $company, 'fiche')
					,'self'=>$_SERVER['PHP_SELF']
				)
			)
		); 
		
	}
	else {
		print TTemplate::liste($conf, $user, $db, $company, 'companyList');
	}
	
	$db->close();