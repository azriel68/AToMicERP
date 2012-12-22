<?
/*
 * Fonction d'initialisation des ExtraFields du thème en cours
 * E : objet standart , 'type extrafields'
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

function createExtraFields(&$objet, $typeObjet) {
	
	$Tab = isset($TExtraFields[$typeObjet]) ? $TExtraFields[$typeObjet] : array();  
	foreach($Tab as $field=>$info) {
		
		if(is_array($info)) {
			$type_champs= isset( $info['type'] ) ? $info['type'] : $info[0];	
			$length = isset( $info['length'] ) ? $info['lenght'] : $info[1];						
		}
		else {
			$type_champs=$info;
		}
		
		
		
		
		unset($length);
	}
	
}
