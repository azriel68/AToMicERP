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
				case 'NEW':
									
					return 'new';
					break;
			
				case 'VIEW':
					$object->load($db, $_REQUEST['id']);
					break; 
				case 'SAVE':
				
					$object->set_values($db, $_POST);
					return 'save';
					break; 
				case 'DELETE':
					$object->delete($db);
					return 'delete';
					break; 
				
			}
			
		}
		else {
			return false;
		}
		
	}
	
	static function liste(&$conf, &$db, &$object) {
		
		print TTemplate::header($conf);
		
		$r=new TSSRenderControler($object);
		$r->liste($db);
		
		print TTemplate::footer($conf);
		
		$className = get_class($object);
		
		if($className=='TCompany') {
			?>
			
			<?
		}
		
		
	}
	
	static function fiche(&$conf, &$object, $template) {
		
		$tbs=new TTemplateTBS;
		
		$className = get_class($object);
		
		print $tbs->render($template
			,array()
			,array(
				$object->objectName=>$object->get_values()
				,'tpl'=>array(
					'header'=>TTemplate::header($conf)
					,'footer'=>TTemplate::footer($conf)
					,'buttons'=>TTemplate::buttons()
					,'self'=>$_SERVER['PHP_SELF']
				)
			)
		); 
		
		
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
