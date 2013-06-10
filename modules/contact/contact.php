<?

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$contact=new TContact;
$db=new TPDOdb;
$action = TTemplate::actions($db, $user, $contact);

// Display from the company module, company is the parent
if(!empty($_REQUEST['id_company'])) {
	$id_parent = $_REQUEST['id_company']; // où est défini adresse ? :: !empty($address->id_company) ? $address->id_company : $_REQUEST['id_company'];
	$id_parent_name = 'id_company';
	$parent = new TCompany;
	$parent->load($db, $id_parent);
}

if($action!==false ) {

	if($action=='save' && !empty($parent) ) {
		// User association with company
		$parent->addContact($contact);	
		$parent->save($db);
		
	}
	else if($action=='delete') {
		header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
	}

	$form=new TFormCore;
	$form->Set_typeaff($action);
	
	$TForm=array(
		'id_entity'=>$form->combo('', 'id_entity', TEntity::getEntityForCombo($db, $user->getEntity()), $contact->id_entity)
		
		,'firstname'=>$form->texte('', 'firstname', $contact->firstname, 80)
		,'lastname'=>$form->texte('', 'lastname', $contact->lastname, 80)
		,'phone'=>$form->texte('', 'phone', $contact->phone, 80)
		,'fax'=>$form->texte('', 'fax', $contact->fax, 80)
		,'email'=>$form->texte('', 'email', $contact->email, 80)
		,'lang'=>$form->texte('', 'lang', $contact->lang, 80)
		,'lang'=>$form->combo('', 'lang', TDictionary::get($db, $user, $contact->id_entity, 'lang'), $contact->lang)
		
		,'id'=>$contact->getId()
		,'dt_cre'=>$contact->get_date('dt_cre')
		,'dt_maj'=>$contact->get_date('dt_maj')
		
		,'gravatar'=>$contact->gravatar()
	);
	$tbs=new TTemplateTBS;
	
	
	
	$buttonsMore='';
	if(!empty($parent)) {
		$buttonsMore = '&'.$id_parent_name.'='.$id_parent;
	}
	
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $contact)
		,array(
			'button'=>TTemplate::buttons($user, $contact, $action, $buttonsMore)
		)
		,array(
			'contact'=>$TForm
			,'parent'=>empty($parent) ? array() : $parent
			/* Apparement inutilisé
			 *,'parentClass'=>empty($parent) ? '' : get_class($parent)*/
			,'id_parent_name'=>empty($parent) ? '' : $id_parent_name
			,'tpl'=>array(
				'header'=>TTemplate::header($conf)
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>!empty($parent) ? TTemplate::tabs($conf, $user, $parent, 'contact') : TTemplate::tabs($conf, $user, $contact, 'card')
				,'self'=>$_SERVER['PHP_SELF']
				,'mode'=>$action
				,'parentShort'=>empty($parent) ? '' : $tbs->render(TTemplate::getTemplate($conf, $parent, 'short'), array(), array('objectShort' => $parent))
				,'hook'=>TAtomic::hook($conf, get_class($contact), __FILE__, array( 'object'=>&$contact, 'action'=>$action ) )
			)
		)
	)); 
	
}
else {
	$listName = empty($parent) ? 'ContactList' : get_class($parent).'ContactList';
	$className = get_class($contact);
	$l = new TListviewTBS('list_'.$className);
	
	$sql = strtr($conf->list->{$className}->{$listName}['sql'],array(
		'@getEntity@'=>$user->getEntity()
		,'@id_company@'=>!empty($_REQUEST['id_company']) ? $_REQUEST['id_company'] : ''
	));
	
	$param = $conf->list->{$className}->{$listName}['param'];
	$param['translate'] = array(
		'lang'=>TDictionary::get($db, $user, $user->id_entity_c, 'lang')
	);
	
	$buttonsMore='';
	if(!empty($parent)) {
		$param['link']['name']='<a href="'.HTTP.'modules/contact/contact.php?action=view&id=@id@&'.$id_parent_name.'='.$parent->getId().'">@name@</a>';
		$buttonsMore = '&'.$id_parent_name.'='.$id_parent;
	}
	
	
	
	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $contact, $listName)
		,array(
			'button'=>TTemplate::buttons($user, $contact, 'list', $buttonsMore)
		)
		,array(
			'tpl'=>array(
				'header'=>TTemplate::header($conf)
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>empty($parent) ? '' : TTemplate::tabs($conf, $user, $parent, 'contact')
				,'self'=>$_SERVER['PHP_SELF']
				,'list'=>$l->render($db, $sql, $param)
				,'parentShort'=>empty($parent) ? '' : $tbs->render(TTemplate::getTemplate($conf, $parent, 'short'), array(), array('objectShort' => $parent))
			)
		)
	)); 
}

$db->close();
