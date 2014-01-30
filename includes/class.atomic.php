<?php

class TAtomic {
	
	static function errorlog ($message) {
		
		$trace=debug_backtrace();       
	      
        $log=date('Y-m-d H:i:s').' - '.$message; 
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
		
		$login = __get('login','','string',30);
		$password = __get('password','','string',30);
		$id_entity = __get('id_entity', 0, 'integer');
		$action = __get('action','');
		$back = __get('back',false, 'boolean');
		$UId = __get('UId', '', 'string', 50);
		
		if(!empty($login) && !empty($password) && $action == 'login') {
			$db=new TPDOdb;
			
			
			if($user->login($db, $login, $password, $id_entity)) {
					
				if($back) {
					header('location:'.$back);
				}
				
			}
			$db->close();
			
		}
		else if(!empty($UId)) {
			$db=new TPDOdb;
			$user->loginUId($db, $UId);
			$db->close();
		}
		else {
				
			null; // user already logged	
		}
		
		return $user;
	}
	
	static function getConf(&$user) {
		if(empty($user->conf)) {
			$db=new TPDOdb;
			
			$TEntity = $user->getEntity('array');
			foreach($TEntity as $id_entity) {
				
				$user->conf[$id_entity] = TConf::loadConf($db, $id_entity);	
			}
			
			$db->close();
		}
	}
	
	static function translate(&$conf, $sentence) {
		
		$translated_sentence = !empty($conf->lang[$sentence]) ? $conf->lang[$sentence] : $sentence;
		
		return $translated_sentence;
	}

	static function activateModule(&$conf, $moduleName) {
		if(!isset($conf->moduleEnabled[$moduleName])) {
			
			// TODO activation du module en base
			
			
			$conf->moduleEnabled[$moduleName]=true;
		}
		
	}

	static function loadModuleDependencie(&$conf, $moduleName) {
		
		if(isset($conf->moduleEnabled[$moduleName]['moduleRequire'])) {
			
			foreach($conf->moduleEnabled[$moduleName]['moduleRequire'] as $subModuleName) {
				
				TAtomic::activateModule($conf, $subModuleName);
				
			}
			
		}
		
		
	}
	
	static function orderModules(&$conf) {
		// TODO réordonne le chargement des modules 
		
		foreach($conf->modules as $moduleName=>$options) {
			
			
		}
		
	}
	
	static function loadModule(&$conf) {
		$dir = ROOT.'modules/';
		
		$moduleToLoad = array_merge($conf->moduleCore, $conf->moduleEnabled);
		// Load conf of all existing modules
		foreach($moduleToLoad as $moduleName=>$options) {
			if(is_file($dir.$moduleName.'/config/config.php')) require($dir.$moduleName.'/config/config.php');
			
			$conf->modules[$moduleName]['enabled']=true;
			
			TAtomic::loadModuleDependencie($conf, $moduleName);
			
			if(is_dir($dir.$moduleName.'/class/')) {
				TAtomic::loadClass($conf, $dir.$moduleName.'/class/');
			}
					
		}

		TAtomic::orderModules($conf);

		// Load files from modules only if core or enabled module
		foreach($moduleToLoad as $moduleName=>$options) {
			if(!empty($conf->modules[$moduleName])) {
				if(is_file($dir.$moduleName.'/lib/function.php')) require($dir.$moduleName.'/lib/function.php');
				
				if(is_file($dir.$moduleName.'/js/script.js')) $conf->js[] = HTTP.'modules/'.$moduleName.'/js/script.js';
				if(is_file($dir.$moduleName.'/js/script.js.php')) $conf->js[] = HTTP.'modules/'.$moduleName.'/js/script.js.php';
				
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
	
	static function addHook(&$conf, $className, $hook) {
		
		if(!isset($conf->hooks->{$className})) @$conf->hooks->{$className} = array();
		
		$conf->hooks->{$className}[] = $hook;	
		
	}
	static function hook(&$conf, $className, $fileName, $TParameters=array()) {
		if(!isset($conf->hooks->{$className})) return false;
		
		$pageName = substr($fileName, strlen(ROOT.'modules/'),-4);
		$resultat='';
		
		foreach($conf->hooks->{$className} as $hook) {
			$resultat.= call_user_func(array($hook['object'],$hook['function']), $className, $pageName, array_merge($hook['parameters'],  $TParameters) );
		}
		
		return $resultat;
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
	
	/*
	 * Créée ou mise à jour de la base de données
	 * 
	 */
	
	static function createMajBase(&$db, &$conf) {
		
		foreach (array_merge($conf->moduleCore, $conf->moduleEnabled) as $moduleName=>$options) {
			
			$module = $conf->modules[$moduleName];
			
			if (isset($module['class'])) {
		
				foreach ($module['class'] as $className) {
		
					$o = new $className;
					if (method_exists($o, 'init_db_by_vars')) {
						$o -> init_db_by_vars($db);
					}
		
				}
		
			}
		
		}
			
	}
	
}
