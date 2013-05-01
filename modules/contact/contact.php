<?

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login();		
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
	print TTemplate::liste($conf, $user, $db, $contact, 'contactList');
}

$db->close();
