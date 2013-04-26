<?php

class TTemplate {
	
	
	static function login() {
		header('location:'.HTTP.'?logout');
		exit;
	}
	/*
	 * Effectue les actions courantes de l'interface	
	 * E : dbConnection, StdObjet
	 * S : actions effectuée 
	 */
	static function actions(&$db, &$user, &$object) {
	 	
		if(isset($_REQUEST['action'])) {
			switch ($_REQUEST['action']) {
				case 'new':
					return 'edit';
					break;
					
				case 'edit':
					$object->load($db, $_REQUEST['id']);
					return 'edit';
					break;
					
				case 'view':
					$object->load($db, $_REQUEST['id']);
					return 'view';
					break;
					
				case 'save':
					$object->load($db, $_REQUEST['id']);
					$object->set_values($_POST);
					if(empty($object->id_entity)) {
						$object->id_entity = $user->id_entity;
					}
					
					$object->save($db);
					return 'save';
					break;
					
				case 'delete':
					$object->load($db, $_REQUEST['id']);
					$object->delete($db);
					return 'delete';
					break;
					
			}
		}
		else {
			return false;
		}
		
	}
	static function getTemplate(&$conf, $object, $mode='fiche') {
		if(is_object($object)) {
			$objectName = get_class($object);
		}
		else {
			$objectName = $object;
		}	
		
		if(isset($conf->template->{$objectName}->{$mode})) {
			return $conf->template->{$objectName}->{$mode};
		}
		else if($mode=='list') {
			return THEME_TEMPLATE_DIR.'list.html';
		}
		else {
			TAtomic::errorlog( 'ErrorBadTemplateDefinition' );
		}
		
	}
	static function liste(&$conf, &$user, &$db, &$object, $listname='index', $param=array()) {
		/*
		 * Fonction à changer, non conforme à une démarche module
		 */
		$className = get_class($object);
		$l = new TListviewTBS('list_'.$className);
		
		$sql = strtr($conf->list->{$className}->{$listname}['sql'],array(
			'@user->id_entity@'=>$user->id_entity
		));
		
		$param = array_merge($conf->list->{$className}->{$listname}['param'] , $param);
		
		$tbs=new TTemplateTBS;
		
		$template = TTemplate::getTemplate($conf, $object,'list');
		
		return __tr_view($tbs->render($template
			,array(
				'button'=>TTemplate::buttons($user, $object, 'list')
			)
			,array(
				'tpl'=>array(
					'header'=>TTemplate::header($conf)
					,'footer'=>TTemplate::footer($conf)
					,'menu'=>TTemplate::menu($conf, $user)
					,'self'=>$_SERVER['PHP_SELF']
					,'list'=>$l->render($db, $sql, $param)
				)
			)
		)); 
		
		
	}
	
	
	static function header(&$conf) {
		$tbs=new TTemplateTBS;
		
		//print_r($conf);
		return $tbs->render(TPL_HEADER,
			array(
				'js'=>$conf->js
			)
			,array(
				'tpl'=>array('templateRoot'=>HTTP_TEMPLATE, 'id'=>'test', 'title'=>'test')
			)
		);
		
	}
	static function footer(&$conf) {
		$tbs=new TTemplateTBS;
		
		return $tbs->render(TPL_FOOTER,
			array()
			,array(
			
			)
		);
		
	}
	static function buttons(&$user, &$object, $mode='fiche') {
		$TButton=array();
		
		if($mode=='list') {
			//if($user->right(get_class($object), 'main', 'create')) {
				$TButton[]=array(
					'href'=>'?action=new'
					,'class'=>'butAction'
					,'label'=>__tr('new'.get_class($object))
				);
			//}
		}
		else if($mode=='save' || $mode=='view') {
			//if($user->right(get_class($object), 'main', 'create')) {
				$TButton[]=array(
					'href'=>'?action=edit&id='.$object->getId()
					,'class'=>'butAction'
					,'label'=>__tr('edit'.get_class($object))
				);
			//}
			//if($user->right(get_class($object), 'main', 'delete')) {
				$TButton[]=array(
					'href'=>'?action=delete&id='.$object->getId()
					,'class'=>'butAction'
					,'label'=>__tr('delete'.get_class($object))
				);
			//}
		}
		else if($mode=='edit') {
			//if($user->right(get_class($object), 'main', 'create')) {
				$formName = 'form'.get_class($object);
				$TButton[]=array(
					'href'=>'javascript:document.forms[\''.$formName.'\'].submit()'
					,'class'=>'butAction'
					,'label'=>__tr('save'.get_class($object))
				);
			//}
			//if($user->right(get_class($object), 'main', 'delete')) {
				$TButton[]=array(
					'href'=>'?action=view&id='.$object->getId()
					,'class'=>'butAction'
					,'label'=>__tr('cancel'.get_class($object))
				);
			//}
		}
		
		
		
		return $TButton;
	}
	
	static function tabs(&$conf, &$user, &$object, $idActive=null) {
		
		if($object->getId()==0) return '';
		
		$tbs=new TTemplateTBS;
		
		$Tab = array();
		
		$className = get_class($object);
		
		foreach($conf->tabs->{$className} as $id=>$tab) {
			
			$mode = !empty($tab['mode']) ? $tab['mode'] : 'main';
			$submodule = !empty($tab['submodule']) ? $tab['submodule'] : 'main';
			
			if( $user->right($className, $submodule, $mode) ) {
				$tab['url']=strtr($tab['url'], array('@id@'=> $object->getId() ));
				@$tab['class'] .= ($id==$idActive) ? ' active' : ' inactive';
				
				$Tab[] = $tab;
			}			
		}
		
		//print_r($conf);
		return $tbs->render(TPL_TABS,
			array(
				'tab'=>$Tab
			)
		);
		
		
	}
	
	static function menu(&$conf, &$user) {
		
		$tbs=new TTemplateTBS;
		
		$menuTop = array();
		
		foreach($conf->menu->top as $menu) {
			if( $user->right($menu['id']) ) {
				$menuTop[] = $menu;
			}			
		}
		
		//print_r($conf);
		return $tbs->render(TPL_MENU,
			array(
				'menuTop'=>$menuTop
			)
			,array(
				'atomicerp'=>array(
					'url'=>HTTP
					,'logo'=>ATOMIC_LOGO
				)
				,'profile'=>array(
					'user_url'=>HTTP.'user/user.php?id='.$user->getId()
					,'user_name'=>$user->login
					,'logout_url'=>HTTP.'?logout'
					,'logout'=>'logout'
				)
			)
		);
		
	}
}
