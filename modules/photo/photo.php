<?php

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$photo=new TPhoto;
$db=new TPDOdb;

$moreButton='';
if(!empty($_REQUEST['id_product'])) {
	$id_parent = $_REQUEST['id_product'];
	$id_parent_name = 'id_product';
	$parent = new TProduct;
	$parent->load($db, $id_parent);
	$moreButton.='&'.$id_parent_name.'='.$parent->getId()	;
	$typeObject='product';
}
else{
	$typeObject='photo';
}
$db->debug=true;
$action = TTemplate::actions($db, $user, $photo);
//exit;
if($action!==false ) {
	
	if($action=='delete') {
		header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
	}
	elseif($action=='save') {
		if(!empty($_FILES['filename'])) {
			$photo->addFile($_FILES['filename'], $typeObject, $id_parent, $parent->id_entity);
			$photo->save($db);
		}
	
		
	}
	
	$form=new TFormCore;
	$form->Set_typeaff($action);
	$TForm=array(
		'title'=>$form->texte('', 'title', $photo->title, 80)
		,'legend'=>$form->texte('', 'legend', $photo->legend, 80)
		,'source'=>$form->texte('', 'source', $photo->source, 80)
		,'description'=>$form->zonetexte('', 'description', $photo->description, 80)
		,'filename'=>($form->type_aff=='edit') ? $form->fichier('', 'filename', $photo->filename , 80) : '<img src="get.php?id='.$photo->getId().'" />'
		
		,'id'=>$photo->getId()
		,'dt_cre'=>$photo->get_date('dt_cre')
		,'dt_maj'=>$photo->get_date('dt_maj')
	);
	
	if(isset($_REQUEST['id_product'])) {
		$TForm['id_product']=$form->combo('', 'id_product', TProduct::getProductForCombo($db, $user->getEntity()), $photo->id_product);
	}
	
	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $photo)
		,array(
			'button'=>TTemplate::buttons($user, $photo, $action,$moreButton)
		)
		,array(
			'photo'=>$TForm
			,'tpl'=>array(
				'header'=>TTemplate::header($conf, __tr('Photo').' : '.$photo->title  )
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>empty($parent) ? TTemplate::tabs($conf, $user, $photo, 'card') : TTemplate::tabs($conf, $user, $parent, 'photo')
				,'self'=>$_SERVER['PHP_SELF']
				,'mode'=>$action
				,'parentShort'=>empty($parent) ? '' : $tbs->render(TTemplate::getTemplate($conf, $parent, 'short'), array(), array('objectShort' => $parent))
			
			)
		)
	));
}
else { // Liste de tous les produits
	
		$l = new TListviewTBS('list_photo');
		
		$sql = strtr($conf->list->TPhoto->list['sql'],array(
			'@getEntity@'=>$user->getEntity()
		));
		
		if(!empty($_REQUEST['id_product'])) {
			$sql.=" AND id_product=".$id_parent;	
		}
		
		$param =array_merge($conf->list->TPhoto->list['param'],array(
			
		)) ;
		
		$tbs=new TTemplateTBS;
		
		$template = TTemplate::getTemplate($conf, $photo,'list');
		
		
		
		print __tr_view($tbs->render($template
			,array(
				'button'=>TTemplate::buttons($user, $photo, 'list', $moreButton)
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