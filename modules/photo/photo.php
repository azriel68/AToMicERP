<?php

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$photo=new TPhoto;
$db=new TPDOdb;


if(!empty($_REQUEST['id_product'])) {
	$id_parent = $_REQUEST['id_product'];
	$id_parent_name = 'id_product';
	$parent = new TProduct;
	$parent->load($db, $id_parent);
}

$action = TTemplate::actions($db, $user, $photo);

if($action!==false ) {
	
	if($action=='delete') {
		header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
	}
	
	$form=new TFormCore;
	$form->Set_typeaff($action);
	$TForm=array(
		'title'=>$form->texte('', 'legend', $photo->ref, 80)
		,'legend'=>$form->texte('', 'legend', $photo->label, 80)
		,'source'=>$form->texte('', 'source', $photo->label, 80)
		,'description'=>$form->zonetexte('', 'description', $photo->description, 80)
		
		,'id'=>$photo->getId()
		,'dt_cre'=>$product->get_date('dt_cre')
		,'dt_maj'=>$product->get_date('dt_maj')
	);
	
	if(isset($_REQUEST['id_product'])) {
		$TForm['id_product']=$form->combo('', 'id_product', TProduct::getProductForCombo($db, $user->getEntity()), $photo->id_product);
	}
	
	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $photo)
		,array(
			'button'=>TTemplate::buttons($user, $photo, $action)
		)
		,array(
			'product'=>$TForm
			,'tpl'=>array(
				'header'=>TTemplate::header($conf, __tr('Photo').' : '.$photo->label  )
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>TTemplate::tabs($conf, $user, $photo, 'card')
				,'self'=>$_SERVER['PHP_SELF']
				,'mode'=>$action
			)
		)
	));
}
else { // Liste de tous les produits
	
		$l = new TListviewTBS('list_photo');
		
		$sql = strtr($conf->list->TPhoto->list['sql'],array(
			'@getEntity@'=>$user->getEntity()
		));
		
		$param =$conf->list->TPhoto->list['param'] ;
		
		$tbs=new TTemplateTBS;
		
		$template = TTemplate::getTemplate($conf, $photo,'list');
		
		$more = '';
		if(!empty($parent)) {
			$more.='&'.$id_parent_name.'='.$parent->getId()	;
		}
		
		print __tr_view($tbs->render($template
			,array(
				'button'=>TTemplate::buttons($user, $photo, 'list', $more)
			)
			,array(
				'tpl'=>array(
					'header'=>TTemplate::header($conf)
					,'footer'=>TTemplate::footer($conf)
					,'menu'=>TTemplate::menu($conf, $user)
					,'tabs'=>empty($parent) ? '' : TTemplate::tabs($conf, $user, $parent, 'photo')
					,'self'=>$_SERVER['PHP_SELF']
					,'list'=>$l->render($db, $sql, $param)
					,'parentShort'=>empty($parent) ? '' : $tbs->render(TTemplate::getTemplate($conf, $parent, 'short'), array(), array('objectShort' => $parent))
			
				)
			)
		)); 
		
		
	
		
}

$db->close();