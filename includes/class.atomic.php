<?php

class TAtomic {
	
	static function errorlog ($message) {
		
		$trace=debug_backtrace();       
	      
        $log=$message; 
        foreach($trace as $row) {
                if((!empty($row['class']) && $row['class']==__CLASS__) 
                        || (!empty($row['function']) && $row['function']==__FUNCTION__)
                        || (!empty($row['function']) && $row['function']=='call_user_func')) continue;
                        
                $log.=' < L. '.$row['line'];
                if(!empty($row['class']))$log.=' '.$row['class'];
                $log.=' '.$row['function'].'() dans '.$row['file'];
				//print $log;
        }
		
		
		$f1 = fopen(ROOT.'error.log','a');
		fputs($f1, $log."\n");
		fclose($f1);
		
	}
	
	static function getUser() {
		if(!isset($_SESSION['user'])) {
			$_SESSION['user'] = new TUser;
		}
		$user = & $_SESSION['user'];
		
		if(!empty($_REQUEST['login']) && !empty($_REQUEST['password']) && !empty($_REQUEST['action']) && $_REQUEST['action'] == 'login') {
			$db=new TPDOdb;
			$user->login($db, $_REQUEST['login'], $_REQUEST['password'], $_REQUEST['id_entity']);
			$db->close();
		}
		
		return $user;
	}
	
	
	static function getConf(&$user) {
		if(empty($user->conf)) {
			$db=new TPDOdb;
			$user->conf = TConf::loadConf($db, $user->id_entity_c);
			$db->close();
		}
	}
	
	static function translate(&$conf, $sentence) {
		
		$translated_sentence = !empty($conf->lang[$sentence]) ? $conf->lang[$sentence] : $sentence;
		
		return $translated_sentence;
	}
	
	static function loadModule(&$conf) {
		$dir = ROOT.'modules/';
		
		// Load conf of all existing modules
		$handle = opendir($dir); 
		while (false !== ($file = readdir($handle))) {
			if($file!='.' && $file!='..'){
				if(is_dir($dir.$file)){
					if(is_file($dir.$file.'/config/config.php')) require($dir.$file.'/config/config.php');
				}
			}
		}
		closedir($handle);

		// Load files from modules only if core or enabled module
		$moduleToLoad = array_merge($conf->moduleCore, $conf->moduleEnabled);
		foreach($moduleToLoad as $moduleName=>$options) {
			if(!empty($conf->modules[$moduleName])) {
				if(is_file($dir.$moduleName.'/lib/function.php')) require($dir.$moduleName.'/lib/function.php');
				if(is_file($dir.$moduleName.'/js/script.js')) $conf->js[] = HTTP.'modules/'.$moduleName.'/js/script.js';
				if(is_dir($dir.$moduleName.'/class/')) {
					TAtomic::loadClass($conf, $dir.$moduleName.'/class/');
				}
				if(is_dir($dir.$moduleName.'/boxe/')) {
					TAtomic::loadBoxe($conf, $moduleName);
				}
			}
		}
	}
	
	static function loadLang(&$conf, $langCode) {
		$dir = ROOT.'modules/';

		if(empty($langCode)) {
			$langCode=DEFAULT_LANG;
		}
		
		// Load lang files from modules only if core or enabled module
		$moduleToLoad = array_merge($conf->moduleCore, $conf->moduleEnabled);
		foreach($moduleToLoad as $moduleName=>$options) {
			if(!empty($conf->modules[$moduleName])) {
				if(is_file($dir.$moduleName.'/lang/'.$langCode.'.php')) {
					require($dir.$moduleName.'/lang/'.$langCode.'.php');
					$conf->lang = array_merge($language, $conf->lang);
				}
			}
		}
	}
	
	static function loadStyle(&$conf) {
		if(is_dir(THEME_TEMPLATE_DIR.'/css/')) {
			$handle = opendir(THEME_TEMPLATE_DIR.'/css/'); 
			while (false !== ($file = readdir($handle))) {
				if(substr($file,-3)=='css'){
					$conf->css[] = HTTP_TEMPLATE.'css/'.$file;
				}
			}
			closedir($handle);
		}
	}
	
	static function loadBoxe(&$conf, $module) {
		$handle = opendir(ROOT.'modules/'.$module.'/boxe/'); 
		while (false !== ($file = readdir($handle))) {
			if($file[0]!='.') {
				$conf->boxes[$module][$file] = HTTP.'modules/'.$module.'/boxe/'.$file;	
			}
		}
		closedir($handle);
	}
	
	static function loadClass(&$conf, $dir) {
		$handle = opendir($dir); 
		while (false !== ($file = readdir($handle))) {
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
