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


	if($action=='addlink') {
		
		$category->load($db, __get('id_category',0,'int'));
		if($category->id==0) {
			//new category
			
			$category->label = __get('categoryname');
			
			$category->save($db);
		}
		
		$category->addChild($db, $tabName)
		
	}
	else if($action=='delete') {
		header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
	}

	$form=new TFormCore;
	$form->Set_typeaff($action);
	
	$buttonsMore = '&object='.$className.'&id='.$object->id;
	
	$TButton = array();
	//$TButton = TTemplate::buttons($user, $category, 'list', $buttonsMore);
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
	//Tools::pre($object);
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $category)
		,array(
			'button'=>$TButton
			,'TCategoryLink'=>$object->TCategoryLink
		)
		,array(
			'tpl'=>array(
				'header'=>TTemplate::header($conf, __tr('Print'))
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>TTemplate::tabs($conf, $user, $object, 'printer')
				,'self'=>$_SERVER['PHP_SELF']
				,'mode'=>$action
				,'parentShort'=>empty($object) ? '' : $tbs->render(TTemplate::getTemplate($conf, $object, 'short'), array(), array('objectShort' => $object))
				
			)
			,'user'=>$user
			,'parent'=>empty($object) ? array() : $object
			,'id_parent_name'=>empty($className) ? '' : $className
		)
	)); 
	


$db->close();
