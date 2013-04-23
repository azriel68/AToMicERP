<?php

class TAtomic {
	
	static function getUser(&$db) {
			
		if(isset($_SESSION['user'])) {
			$user = $_SESSION['user'];
		}
		else {
			$user = new TUser;
		}
		
		if(!empty($_REQUEST['login']) && !empty($_REQUEST['password'])) {
			$user->login($_REQUEST['login'], $_REQUEST['password']);
		}
		
		return $user;
		
	}
	
	static function translate(&$conf, $sentence) {
		
		$translated_sentence = $sentence;
		
		return $translated_sentence;
	}
	
	static function getTemplate(&$conf, &$object, $mode='fiche') {
		$objectName = get_class($object);
		
		if(isset($conf->template->{$objectName}->{$mode})) {
			return $conf->template->{$objectName}->{$mode};
		}
		else {
			return 'ErrorBadTemplateDefinition';
		}
		
	}
	
	static function loadModule(&$conf) {
		
		$dir = ROOT.'modules/';
		/*$handle = opendir($dir); 
		
		while (false !== ($file = readdir($handle))) {
		   	if($file!='.' && $file!='..'){
				if(is_dir($dir.$file)){
						
					if(is_file($dir.$file.'/config/config.php')) require($dir.$file.'/config/config.php');
					if(is_file($dir.$file.'/lib/function.php')) require($dir.$file.'/lib/function.php');
					
					if(is_file($dir.$file.'/js/script.js')) $conf->js[]=HTTP.'modules/'.$file.'/js/script.js';
					if(is_dir($dir.$file.'/class/')) {
						TAtomic::loadClass($conf, $dir.$file.'/class/');
					}
					
				}
			}
	   }
	   closedir($handle);
		*/
	//	print_r($conf->moduleEnabled);
	   foreach($conf->moduleEnabled as $module=>$options) {
	   				
	   			if(is_dir($dir.$module)){
						
					if(is_file($dir.$module.'/config/config.php')) require($dir.$module.'/config/config.php');
					if(is_file($dir.$module.'/lib/function.php')) require($dir.$module.'/lib/function.php');
					
					if(is_file($dir.$module.'/js/script.js')) $conf->js[]=HTTP.'modules/'.$module.'/js/script.js';
					if(is_dir($dir.$module.'/class/')) {
						TAtomic::loadClass($conf, $dir.$module.'/class/');
					}
					
				}
	   }	
		
	}
	
	static function loadClass(&$conf, $dir) {
		$handle = opendir($dir); 
		
		while (false !== ($file = readdir($handle))) {
			set_time_limit(30);  
		   	if(substr($file,0,5)=='class'){
					require($dir.$file);
			}
	   }
	   closedir($handle);
	}
	
	static function sortMenu(&$conf) {
		$menu = array();
		foreach ($conf->menu->top as $menuElement) {
			$menu[$menuElement['position']] = $menuElement;
		}
		ksort($menu, SORT_NUMERIC);
		$conf->menu->top = $menu;
	}
	
	/*
	 * Fonction d'initialisation des ExtraFields du thème en cours pour l'objet
	 * E : objet standart , 'type extrafields'
	 * S : null
	 */
	static function initExtraFields(&$objet, $typeObjet='') {
	global $TExtraFields;
		
		if($typeObjet=='') $typeObjet = get_class($objet);
		
		$Tab = isset($TExtraFields[$typeObjet]) ? $TExtraFields[$typeObjet] : array();  
		foreach($Tab as $field=>$info) {
			
			if(is_array($info)) {
				$type_champs= isset( $info['type'] ) ? $info['type'] : $info[0];	
			}
			else {
				$type_champs=$info;
			}
			
			$objet->add_champs($field, 'type='+$type_champs+';');
			
			
		}
		
	}
	
}
