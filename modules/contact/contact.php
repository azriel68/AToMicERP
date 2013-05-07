<?

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$contact=new TContact;
$db=new TPDOdb;
$action = TTemplate::actions($db, $user, $contact);
if($action!==false ) {

	if($action=='delete') {
		header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
	}

	$form=new TFormCore;
	$form->Set_typeaff($action);
	
	$TForm=array(
		'firstname'=>$form->texte('', 'firstname', $contact->firstname, 80)
		,'lastname'=>$form->texte('', 'lastname', $contact->lastname, 80)
		,'phone'=>$form->texte('', 'phone', $contact->phone, 80)
		,'fax'=>$form->texte('', 'fax', $contact->fax, 80)
		,'email'=>$form->texte('', 'email', $contact->email, 80)
		,'lang'=>$form->texte('', 'lang', $contact->lang, 80)
		,'lang'=>$form->combo('', 'lang', TDictionary::get($db, 'lang'), $contact->lang)
		
		,'id'=>$contact->getId()
		,'dt_cre'=>$contact->get_date('dt_cre')
		,'dt_maj'=>$contact->get_date('dt_maj')
		
		,'gravatar'=>$contact->gravatar()
	);
	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $contact)
		,array(
			'button'=>TTemplate::buttons($user, $contact, $action)
		)
		,array(
			'contact'=>$TForm
			,'tpl'=>array(
				'header'=>TTemplate::header($conf)
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>TTemplate::tabs($conf, $user, $contact, 'fiche')
				,'self'=>$_SERVER['PHP_SELF']
				,'mode'=>$action
			)
		)
	)); 
	
}
else {
	//print TTemplate::liste($conf, $user, $db, $contact, 'contactList');
	
	$listName = 'contactList';
	$className = get_class($contact);
	$l = new TListviewTBS('list_'.$className);
	
	$sql = strtr($conf->list->{$className}->{$listName}['sql'],array(
		'@user->id_entity@'=>$user->id_entity_c
		,'@getEntity@'=>$user->getEntity()
		,'@id_company@'=>$_REQUEST['id_company']
	));
	
	$param = $conf->list->{$className}->{$listName}['param'];
	
	$tbs=new TTemplateTBS;
	
	$template = TTemplate::getTemplate($conf, $contact,'list');
	
	print __tr_view($tbs->render($template
		,array(
			'button'=>TTemplate::buttons($user, $contact, 'list')
		)
		,array(
			'tpl'=>array(
				'header'=>TTemplate::header($conf)
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'self'=>$_SERVER['PHP_SELF']
				,'list'=>$l->render($db, $sql, $param)
			)
		)
	)); 
}

$db->close();
