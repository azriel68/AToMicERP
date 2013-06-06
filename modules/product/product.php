<?

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$product=new TProduct;
$db=new TPDOdb;

$action = TTemplate::actions($db, $user, $product);

if($action!==false ) {
	
	if($action=='delete') {
		header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
	}
	
	$form=new TFormCore;
	$form->Set_typeaff($action);
	
	$TForm=array(
		'id_entity'=>$form->combo('', 'id_entity', TEntity::getEntityForCombo($db, $user->getEntity()), $product->id_entity)
		,'ref'=>$form->texte('', 'ref', $product->ref, 80)
		,'label'=>$form->texte('', 'label', $product->label, 80)
		,'description'=>$form->zonetexte('', 'description', $product->description, 80)
		,'price'=>$form->texte('', 'price', $product->price, 10)
		
		,'id'=>$product->getId()
		,'dt_cre'=>$product->get_date('dt_cre')
		,'dt_maj'=>$product->get_date('dt_maj')
	);
	
	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $product)
		,array(
			'button'=>TTemplate::buttons($user, $product, $action)
		)
		,array(
			'product'=>$TForm
			,'tpl'=>array(
				'header'=>TTemplate::header($conf, __tr('Product : ').$product->label  )
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>TTemplate::tabs($conf, $user, $product, 'fiche')
				,'self'=>$_SERVER['PHP_SELF']
				,'mode'=>$action
			)
		)
	));
}
else { // Liste de tous les produits
	print TTemplate::liste($conf, $user, $db, $product, 'productList');
}

$db->close();