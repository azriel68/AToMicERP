<?
/*
 * Fonction d'initialisation des ExtraFields du thème en cours pour l'objet
 * E : objet standart , 'type extrafields'
 * S : null
 */
function initExtraFields(&$objet, $typeObjet) {
global $TExtraFields;
	
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
function createExtraFields(&$db, &$objet, $typeObjet) {
	
	$Tab = isset($TExtraFields[$typeObjet]) ? $TExtraFields[$typeObjet] : array();  
	foreach($Tab as $field=>$info) {
		
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
		
		unset($length);
	}
	
}
