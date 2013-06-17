<?

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$bill=new TBill;
$db=new TPDOdb;
$action = TTemplate::actions($db, $user, $bill);

if($action!==false ) {

	if($action=='delete') {
		header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
	}

	$form=new TFormCore;
	$form->Set_typeaff($action);
	
	$TForm=array(
		'id_entity'=>$form->combo('', 'id_entity', TEntity::getEntityForCombo($db, $user->getEntity()), $bill->id_entity)
		,'ref'=>$form->texteRO('', 'ref', $bill->ref, 12)
		,'dt_bill'=>$form->calendrier('', 'dt_bill', $bill->dt_bill, 12)
		,'status'=>$form->texte('', 'status', $bill->status, 40)
		
		,'id'=>$bill->getId()
		,'dt_cre'=>$bill->get_date('dt_cre')
		,'dt_maj'=>$bill->get_date('dt_maj')
	);
	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $bill)
		,array(
			'button'=>TTemplate::buttons($user, $bill, $action)
		)
		,array(
			'bill'=>$TForm
			,'tpl'=>array(
				'header'=>TTemplate::header($conf, __tr('Bill').' '.$bill->ref)
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>TTemplate::tabs($conf, $user, $bill, 'card')
				,'self'=>$_SERVER['PHP_SELF']
				,'mode'=>$action
			)
		)
	)); 
	
}
else {
	print TTemplate::liste($conf, $user, $db, $bill, 'billList');
}

$db->close();
