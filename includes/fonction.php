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
global $TExtraFields;	
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
/*
 * Effectue les actions courantes de l'interface	
 * E : dbConnection, StdObjet
 * S : actions effectuée 
 */
function actions(&$db, &$objet) {
 	
	if(isset($_REQUEST['action'])) {
		switch ($_REQUEST['action']) {
			case 'NEW':
								
				return 'new';
				break;
		
			case 'VIEW':
				$objet->load($db, $_REQUEST['id']);
				break; 
			case 'SAVE':
			
				$objet->set_values($db, $_POST);
				return 'save';
				break; 
			case 'DELETE':
				$objet->delete($db);
				return 'delete';
				break; 
			
		}
		
	}
	else {
		return false;
	}
	
}

function fiche(&$objet, $template) {
	
	$tbs=new TTemplateTBS;
	
	$className = get_class($objet);
	
	print $tbs->render($template
		,array()
		,array(
			$className=>$objet->get_values()
			,'tpl'=>array(
				'header'=>_header()
				,'footer'=>_footer()
				,'buttons'=>_buttons()
				,'self'=>$_SERVER['PHP_SELF']
			)
		)
	); 
	
	
}
function _header() {
	$tbs=new TTemplateTBS;
	
	print $tbs->render(TPL_HEADER,
		array()
		,array(
			'tpl'=>array('templateRoot'=>HTTP_TEMPLATE)
		)
	);
	
}
function _footer() {
	$tbs=new TTemplateTBS;
	
	print $tbs->render(TPL_FOOTER,
		array()
		,array(
		
		)
	);
	
}
function _buttons() {
	ob_start();		
	
	?><input type="button" name="cancel" class="cancel" value="Annuler" /><?
		
	if(isset($_REQUEST['VIEW'])) {
		?><input type="button" name="delete" class="delete" value="Supprimer" /><?
	}
	
	?><input type="submit" name="valid" class="valid" value="Valider" /><?
	
	return ob_get_clean();
}
