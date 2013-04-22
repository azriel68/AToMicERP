<?php

class TAtomic {
	
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
		$handle = opendir($dir); 
		
		while (false !== ($file = readdir($handle))) {
		   	if($file!='.' && $file!='..'){
				if(is_dir($dir.$file)){
						
					if(is_file($dir.$file.'/config/config.php')) require($dir.$file.'/config/config.php');
					if(is_file($dir.$file.'/lib/function.php')) require($dir.$file.'/lib/function.php');
					
					if(is_file($dir.$file.'/js/scripts.js')) $conf->js[]=HTTP.'modules/'.$file.'/js/scripts.js';
					if(is_dir($dir.$file.'/class/')) {
						TAtomic::loadClass($conf, $dir.$file.'/class/');
					}
					
				}
			}
	   }
	   closedir($handle);
		
	}
	
	static function loadClass(&$conf, $dir) {
		$handle = opendir($dir); 
		
		while (false !== ($file = readdir($handle))) {
			set_time_limit(30);  
		   	if(substr($file,0,4)=='class'){
					require($dir.$file);
			}
	   }
	   closedir($handle);
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
	 * Fonction d'initialisation des ExtraFields du thème en cours dans la base
	 * E : dbConnector, objet standart , 'type extrafields'
	 * S : null
	 */
	static function createExtraFields(&$db, &$objet, $typeObjet='') {
		// AA à remplacer par la méthode standard
	global $TExtraFields;	
	
		if($typeObjet=='') $typeObjet = get_class($objet);
	
		print '<h2>Créations des champs de thème supplémentaires pour '.$typeObjet.'</h2>';
		
		$Tab = isset($TExtraFields[$typeObjet]) ? $TExtraFields[$typeObjet] : array();  
	
	
		foreach($Tab as $field=>$info) {
			print "Test du champs : $field...";
			$to_index=false;
			if(is_array($info)) {
				$type_champs= isset( $info['type'] ) ? $info['type'] : $info[0];	
				$length = isset( $info['length'] ) ? $info['lenght'] : $info[1];	
				$to_index =  isset( $info['index'] ) ? $info['index'] : $info[2];					
			}
			else {
				$type_champs=$info;
			}
			
			if(!isset($length)) {
				if($type_champs=='chaine')$length = 255;
				else if($type_champs=='entier')$length = 11;
			}
			
			$db->Execute("SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$objet->get_table()."' AND column_name LIKE '".$field."'");
			if(!$db->Get_line()) {
				/*
				 * Le champs est à créer
				 */
				
				print "Création";
				
				switch ($type_champs) {
					case 'chaine':
						$mysqlType = 'VARCHAR( '.$length.' )';
						break;
					case 'entier':
						$mysqlType = 'INT( '.$length.' )';
						break;
					case 'texte':
						$mysqlType = 'TEXT';
						break;
					case 'date':
						$mysqlType = 'DATETIME';
						break;
				}
				
				$db->Execute("ALTER TABLE `".$objet->get_table()."` ADD  `".$field."` ".$mysqlType." NOT NULL ");		
				if($to_index) $db->Execute("ALTER TABLE `".$objet->get_table()."` ADD INDEX (`".$field."`) ");
				
						
			}
			else {
				print "Existant";
			}	
			
			print '<br/>';
			
			unset($length);
		}
		
	}
}
