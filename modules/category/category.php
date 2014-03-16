<?

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$category=new TCategory;

$className = __get('object');

$object = new $className;
$object->load($db, __get('id',0,'integer'));
$object->loadChildSubObject($db, 'TCategoryLink', 'categorie', 'id_categorie');

$action=__get('action', false);




	if($action=='delete') {
		header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
	}

	$form=new TFormCore;
	$form->Set_typeaff($action);
	
	$buttonsMore = '&object='.$className.'&id='.$object->id;
	
	$TButton = TTemplate::buttons($user, $category, 'list', $buttonsMore);
	if(!empty($object->id)) {
	
		$TButton = array_merge(
				$TButton
				,array(
					'link'=>array(
						'href'=>'javascript:linkToCategory('.$object->id.')'
						,'class'=>'butAction'
						,'label'=>__tr('LinkToCategory')
					)
				)
		);
	}
	
	
	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $printer)
		,array(
			'TCategoryLink'=>$object->TCategoryLink
		)
		,array(
			'printer'=>$TForm
			,'tpl'=>array(
				'header'=>TTemplate::header($conf, __tr('Print'))
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>TTemplate::tabs($conf, $user, $object, 'printer')
				,'self'=>$_SERVER['PHP_SELF']
				,'mode'=>$action
				,'parentShort'=>empty($object) ? '' : $tbs->render(TTemplate::getTemplate($conf, $object, 'short'), array(), array('objectShort' => $object))
				
			)
		)
	)); 
	


$db->close();
