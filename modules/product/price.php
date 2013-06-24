<?php

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$price=new TPrice;
$db=new TPDOdb;
$action = TTemplate::actions($db, $user, $price);

if(!empty($_REQUEST['id_product'])) {
	$id_parent = $_REQUEST['id_product'];
	$id_parent_name = 'id_product';
	$parent = new TProduct;
	$parent->load($db, $id_parent);
}

if($action!==false ) {
	
	if($action=='delete') {
		header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
	}
	
	$form=new TFormCore;
	$form->Set_typeaff($action);
	
	$TForm=array(
		'id_product'=>$form->combo('', 'id_entity', TProduct::getProductForCombo($db, $user->getEntity()), $parent->id_entity)
		,'price_ht'=>$form->texte('', 'ref', $parent->ref, 80)
		
		,'id'=>$parent->getId()
		,'dt_cre'=>$parent->get_date('dt_cre')
		,'dt_maj'=>$parent->get_date('dt_maj')
	);
	
	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $parent)
		,array(
			'button'=>TTemplate::buttons($user, $parent, $action)
		)
		,array(
			'product'=>$TForm
			,'tpl'=>array(
				'header'=>TTemplate::header($conf, __tr('Product : ').$parent->label  )
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>TTemplate::tabs($conf, $user, $parent, 'card')
				,'self'=>$_SERVER['PHP_SELF']
				,'mode'=>$action
				,'parentShort'=>empty($parent) ? '' : $tbs->render(TTemplate::getTemplate($conf, $parent, 'short'), array(), array('objectShort' => $parent))
			
			)
		)
	));
	
	
}
else { // Liste de tous les prix associé au produit
	$listName = empty($parent) ? 'priceList' : get_class($parent).'PriceList';
	$className = get_class($price);
	$l = new TListviewTBS('list_'.$className);
	
	$sql = strtr($conf->list->{$className}->{$listName}['sql'],array(
		'@getEntity@'=>$user->getEntity()
		,'@id_product@'=>!empty($_REQUEST['id_product']) ? $_REQUEST['id_product'] : ''
	));
	
	$param = $conf->list->{$className}->{$listName}['param'];
	$param['translate'] = array(
		'lang'=>TDictionary::get($db, $user, $user->id_entity_c, 'lang')
	);
	
	$buttonsMore='';
	if(!empty($parent)) {
		$param['link']['name']='<a href="'.HTTP.'modules/product/product.php?action=view&id=@id@&'.$id_parent_name.'='.$parent->getId().'">@name@</a>';
		$buttonsMore = '&'.$id_parent_name.'='.$id_parent;
	}
	
	$tbs=new TTemplateTBS;
	
	//echo $listName;
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $price, $listName)
		,array(
			'button'=>TTemplate::buttons($user, $price, 'list', $buttonsMore)
		)
		,array(
			'tpl'=>array(
				'header'=>TTemplate::header($conf)
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>empty($parent) ? '' : TTemplate::tabs($conf, $user, $parent, 'price')
				,'self'=>$_SERVER['PHP_SELF']
				,'list'=>$l->render($db, $sql, $param)
				,'parentShort'=>empty($parent) ? '' : $tbs->render(TTemplate::getTemplate($conf, $parent, 'short'), array(), array('objectShort' => $parent))
			)
		)
	));
}

$db->close();