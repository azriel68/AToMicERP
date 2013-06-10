<?php

class TTemplate {
	
	static function login(&$user) {
		//print_r($user);exit;
		if(!empty($user->errorLogin)) {
			header('location:'.HTTP.'?error=Bad login or password');
		}
		else {
			header('location:'.HTTP.'?logout&back='.urlencode($_SERVER["REQUEST_URI"]));	
		}
		
		
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
					
				default:
					return false;
					break;
			}
		}
		else {
			return false;
		}
		
	}
	static function getTemplate(&$conf, $object, $mode='card') {
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
		else if($mode=='data-table') {
			return THEME_TEMPLATE_DIR.'data-table.html';
		}
		else {
			TAtomic::errorlog( 'ErrorBadTemplateDefinition' );
		}
		
	}
	static function getBoxes(&$conf, &$user) {
		
		$Tab=array();
		foreach($conf->boxes as $module=>$TBoxe) {
			foreach($TBoxe as $boxe) {
				$url = $boxe.'?UId='.$user->UId;
				
				array_push( $Tab, file_get_contents($url) );	
			}
			
		}
		
		
		return $Tab;
	}
	static function gravatar($email, $title='gravatar', $size=100, $float="none") {
		$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
		return '<img src="'.$grav_url.'" alt="'.$title.'" style="float:'.$float.'" />';
	}

	static function liste(&$conf, &$user, &$db, &$object, $listname='index', $param=array()) {
		/*
		 * Fonction à changer, non conforme à une démarche module
		 */
		$className = get_class($object);
		$l = new TListviewTBS('list_'.$className);
		
		$sql = strtr($conf->list->{$className}->{$listname}['sql'],array(
			'@user->id_entity@'=>$user->id_entity_c
			,'@getEntity@'=>$user->getEntity()
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
	
	static function listeDataTable(&$conf, &$user, &$db, &$object, $listName, $TParam=array()) {
		$tbs=new TTemplateTBS;
		
		$className = get_class($object);
		$template = TTemplate::getTemplate($conf, $object,'data-table');
		
		$params = '&TParam[@user->id_entity]='.$user->id_entity_c;
		$url = HTTP.'script/ajax-data-table.php?className='.$className.'&listName='.$listName;
		
		$header = $conf->list->{$className}->{$listName}['header'];
		
		return $tbs->render($template
			,array(
				'button'=>TTemplate::buttons($user, $object, 'list')
				,'columns'=>$header
			)
			,array(
				'tpl'=>array(
					'listName'=>$listName
					,'http'=>HTTP
					,'url_ajax_data_table'=>$url
					,'url_lang_data_table'=>HTTP.'modules/core/lang/fr_FR.txt'
					,'column_count'=>count($header)
					,'id_entity'=>$user->id_entity_c
				)
			)
		);
	}
	
	
	static function header(&$conf, $title='AtomicERP', $successMessage='', $errorMessage='', $id="page") {
		$tbs=new TTemplateTBS;
		
		if(isset($_REQUEST['success'])) {
			$success = TTemplate::success($_REQUEST['success']);
		}
		else if(!empty($successMessage)) {
			$success = TTemplate::success($successMessage);
		}
		else {
			$success = '';
		}
		
		//print_r($conf);
		return $tbs->render(TPL_HEADER,
			array(
				'js'=>$conf->js
				,'css'=>$conf->css
			)
			,array(
				'tpl'=>array(
					'templateRoot'=>HTTP_TEMPLATE
					, 'id'=>$id
					, 'title'=>$title
					, 'http'=>HTTP
					, 'error'=> isset($_REQUEST['error']) ? TTemplate::error($_REQUEST['error']) :''
					, 'success'=> $success
					)
			)
		);
		
	}
	static function success($message) {
		ob_start();
		
		?><script type="text/javascript">
		$(document).ready(function() {
			
		
		jSuccess(
			'<?=addslashes($message) ?>',
			{
			  autoHide : true, // added in v2.0
			  MinWidth : 250,
			  TimeShown : 2000,
			  ShowTimeEffect : 200,
			  HideTimeEffect : 200,
			  LongTrip :20,
			  HorizontalPosition : 'right',
			  VerticalPosition : 'top',
			  ShowOverlay : false,
	   		  ColorOverlay : '#000',
			  onClosed : function(){ // added in v2.0
			   
			  },
			  onCompleted : function(){ // added in v2.0
			   
			  }
			});
		  });
	  		
		</script>
		
		
		<?
		
		return ob_get_clean();
		
	}
	
	static function error($message) {
		ob_start();
		
		?><script type="text/javascript">
		$(document).ready(function() {
			
			  jError(
				'<?=addslashes($message) ?>',
				{
				  autoHide : true, // added in v2.0
				  clickOverlay : true, // added in v2.0
				  MinWidth : 250,
				  TimeShown : 3000,
				  ShowTimeEffect : 200,
				  HideTimeEffect : 200,
				  LongTrip :20,
				  HorizontalPosition : 'center',
				  VerticalPosition : 'top',
				  ShowOverlay : true,
		   		  ColorOverlay : '#000',
				  OpacityOverlay : 0.3,
				  onClosed : function(){ // added in v2.0
				   
				  },
				  onCompleted : function(){ // added in v2.0
				   
				  }
				});
		});
			
		</script>
		
		
		<?
		
		return ob_get_clean();
	}
	static function footer(&$conf) {
		$tbs=new TTemplateTBS;
		
		return $tbs->render(TPL_FOOTER,
			array()
			,array(
			
			)
		);
		
	}
	static function buttons(&$user, &$object, $mode='card', $more='') {
		$TButton=array();
		
		if($mode=='list') {
			//if($user->right(get_class($object), 'main', 'create')) {
				$TButton['new']=array(
					'href'=>'?action=new'.$more
					,'class'=>'butAction'
					,'label'=>__tr('new'.get_class($object))
				);
			//}
		}
		else if($mode=='save' || $mode=='view') {
			//if($user->right(get_class($object), 'main', 'create')) {
				$TButton['edit']=array(
					'href'=>'?action=edit&id='.$object->getId().$more
					,'class'=>'butAction'
					,'label'=>__tr('edit'.get_class($object))
				);
			//}
			//if($user->right(get_class($object), 'main', 'delete')) {
				$TButton['delete']=array(
					'href'=>'?action=delete&id='.$object->getId().$more
					,'class'=>'butAction'
					,'label'=>__tr('delete'.get_class($object))
				);
			//}
		}
		else if($mode=='edit') {
			//if($user->right(get_class($object), 'main', 'create')) {
				$formName = 'form'.get_class($object);
				$TButton['save']=array(
					'href'=>'javascript:document.forms[\''.$formName.'\'].submit()'
					,'class'=>'butAction'
					,'label'=>__tr('save'.get_class($object))
				);
			//}
			//if($user->right(get_class($object), 'main', 'delete')) {
				$TButton['cancel']=array(
					'href'=> ($object->getId() > 0) ? '?action=view&id='.$object->getId().$more : '?action=list'.$more
					,'class'=>'butAction'
					,'label'=>__tr('cancel'.get_class($object))
				);
			//}
		}
		
		
		
		return $TButton;
	}
	static function addTabs(&$conf, $className, $Tab) {
		
		if(!isset($conf->tabs->{$className}))$conf->tabs->{$className}=array();
		
		foreach($Tab as $name=>$content) {
			
			if(empty($content['rank'])){
				$content['rank'] = count($conf->tabs->{$className});
			} 
			
			$conf->tabs->{$className}[$name] = $content;	
		}
		
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
				$tab['class'] = ($id==$idActive) ? 'active' : 'inactive';
				
				$Tab[] = $tab;
			}
		}
		
		usort($Tab, array('TTemplate', 'tabsRankOrder'));
		
		return $tbs->render(TPL_TABS,
			array(
				'tab'=>$Tab
			)
			,array(
				'tpl'=>array(
					'tabtitle'=>__tr(get_class($object))
				)
			)
		);
	}
	static function tabsRankOrder($a, $b) {
		if($a['rank']>$b['rank']) {
			return 1;
		}
		else if($a['rank']<$b['rank']) {
			return -1;
		}
		
		return 0;	
	}
	static function getIcon(&$conf, $id_module) {
		if(isset($conf->modules[$id_module]['icon'])) {
			return HTTP.'modules/'.$id_module.'/image/' . $conf->modules[$id_module]['icon'];
		}
		else  {
			return HTTP_TEMPLATE.'images/default-menu-icon.png';	
		}
	}
	static function menu(&$conf, &$user) {
		
		$tbs=new TTemplateTBS;
		
		$menuTop = array();
		
		foreach($conf->menu->top as $menu) {
			
			if(empty($menu['icon'])) {
				
					$menu['icon']= TTemplate::getIcon($conf, !empty($menu['module']) ? $menu['module'] : null);
				
			}
			
			
			if(empty($menu['rights'])){
				$menuTop[] = $menu;
			}
			else if( $user->right($menu['rights'][0],$menu['rights'][1],$menu['rights'][2]) ) {
				$menuTop[] = $menu;
			}
						
		}
		
		$menuAdmin = array();
		foreach($conf->menu->admin as $menu) {
			
			$menu['url'] = strtr($menu['url'],array('@id@'=>$user->getId()));
			
			if(empty($menu['rights'])){
				$menuAdmin[] = $menu;
			}
			else if( $user->right($menu['rights'][0],$menu['rights'][1],$menu['rights'][2]) ) {
				$menuAdmin[] = $menu;
			}
		}
		
		//print_r($conf);
		return $tbs->render(TPL_MENU,
			array(
				'menuTop'=>$menuTop
				,'menuAdmin'=>$menuAdmin
			)
			,array(
				'tpl'=>array(
					'http'=>HTTP
					,'logo'=>ATOMIC_LOGO
					,'logout_url'=>HTTP.'?logout'
				)
				,'user'=>$user
			)
		);
		
	}
}
