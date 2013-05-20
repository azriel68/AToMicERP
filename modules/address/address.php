<?

// Includes global vars and configuration
require('../../inc.php');

// Check if user is connected to access this page
if(!$user->isLogged()) {
	TTemplate::login($user);
}

// Database connection and object actions
$db=new TPDOdb;
$address=new TAddress;
$action = TTemplate::actions($db, $user, $address);

// The address object can be related to a company or to a contact. We load the corresponding parent object
if(!empty($address->id_company) || !empty($_REQUEST['id_company'])) {
	$id_parent = !empty($address->id_company) ? $address->id_company : $_REQUEST['id_company'];
	$id_parent_name = 'id_company';
	$parent = new TCompany;
} else if(!empty($address->id_contact) || !empty($_REQUEST['id_contact'])) {
	$id_parent = !empty($address->id_contact) ? $address->id_contact : $_REQUEST['id_contact'];
	$id_parent_name = 'id_contact';
	$parent = new TContact;
}

$parent->load($db, $id_parent);

if($action!==false ) {

	if($action=='delete') {
		header('location:'.$_SERVER['PHP_SELF'].'?'.$id_parent_name.'='.$id_parent.'&delete=ok');
	}

	$form=new TFormCore;
	$form->Set_typeaff($action);
	
	$TForm=array(
		'address'=>$form->zonetexte('', 'address', $address->address, 40, 3)
		,'zip'=>$form->texte('', 'zip', $address->zip, 7)
		,'city'=>$form->texte('', 'city', $address->city, 30)
		,'country'=>$form->combo('', 'country', TDictionary::get($db, $user, $parent->id_entity, 'country'), $address->country)
		,'isDefaultBilling'=>$form->combo('', 'isDefaultBilling', TDictionary::get($db, $user, $parent->id_entity, 'yesno'), $address->isDefaultBilling)
		,'isDefaultShipping'=>$form->combo('', 'isDefaultShipping', TDictionary::get($db, $user, $parent->id_entity, 'yesno'), $address->isDefaultShipping)
		
		,'id'=>$address->getId()
		,'dt_cre'=>$address->get_date('dt_cre')
		,'dt_maj'=>$address->get_date('dt_maj')
	);
	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $address)
		,array(
			'button'=>TTemplate::buttons($user, $address, $action, '&'.$id_parent_name.'='.$id_parent)
		)
		,array(
			'address'=>$TForm
			,'parent'=>$parent
			,'parentClass'=>get_class($parent)
			,'id_parent_name'=>$id_parent_name
			,'tpl'=>array(
				'header'=>TTemplate::header($conf, __tr('Address'))
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>TTemplate::tabs($conf, $user, $parent, 'address')
				,'self'=>$_SERVER['PHP_SELF']
				,'mode'=>$action
				,'parentShort'=>$tbs->render(TTemplate::getTemplate($conf, $parent, 'short'), array(), array('objectShort' => $parent))
			)
		)
	)); 
	
}
else {
	$listName = get_class($parent).'AddressList';
	$className = get_class($address);
	$l = new TListviewTBS('list_'.$className);
	
	$sql = strtr($conf->list->{$className}->{$listName}['sql'],array(
		'@'.$id_parent_name.'@'=>$id_parent
	));
	
	$param = $conf->list->{$className}->{$listName}['param'];
	$param['translate'] = array(
		'country'=>TDictionary::get($db, $user, $parent->id_entity, 'country')
	);
	$param['link']['address']='<a href="?action=view&id=@id@&'.$id_parent_name.'='.$parent->getId().'">@val@</a>';
	
	
	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $address, $listName)
		,array(
			'button'=>TTemplate::buttons($user, $address, 'list', '&'.$id_parent_name.'='.$id_parent)
		)
		,array(
			'tpl'=>array(
				'header'=>TTemplate::header($conf, __tr('Address'))
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>TTemplate::tabs($conf, $user, $parent, 'address')
				,'self'=>$_SERVER['PHP_SELF']
				,'list'=>$l->render($db, $sql, $param)
				,'parentShort'=>$tbs->render(TTemplate::getTemplate($conf, $parent, 'short'), array(), array('objectShort' => $parent))
			)
		)
	));
}

$db->close();