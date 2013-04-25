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
	static function actions(&$db, &$object) {
	 	
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
				
					$object->set_values($_POST);
					$bject->save($db);
					
					return 'save';
					break; 
				case 'delete':
					$object->delete($db);
					return 'delete';
					break; 
				
			}
			
		}
		else {
			return false;
		}
		
	}
	
	static function liste(&$conf, &$user, &$db, &$object, $param=array(), $buttons=array()) {
		/*
		 * Fonction à changer, non conforme à une démarche module
		 */
		 
		print TTemplate::header($conf);
		print TTemplate::menu($conf, $user);
		
		?><div class="fiche"><?
		
		$r=new TSSRenderControler($object);
		$r->liste($db);
		
		?><a href="?action=new" class="butAction"><?=__tr('new'.get_class($object))?></a> </div><?
		
		print TTemplate::footer($conf);
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
	static function buttons() {
		ob_start();		
		
		?><input type="button" name="cancel" class="cancel" value="Annuler" /><?
			
		if(isset($_REQUEST['VIEW'])) {
			?><input type="button" name="delete" class="delete" value="Supprimer" /><?
		}
		
		?><input type="submit" name="valid" class="valid" value="Valider" /><?
		
		return ob_get_clean();
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
		);
		
	}
}
