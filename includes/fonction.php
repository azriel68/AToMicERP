<?
/* Abreviation de translation
 * E : phrase
 * S : pĥrase traduite 
 */
function __tr($sentence) {
	global $conf;
	
	return TAtomic::translate($conf, $sentence);
	
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
function liste(&$db, &$object) {
	
	$r=new TSSRenderControler($object);
	$r->liste($db);
	
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
function _header(&$conf) {
	$tbs=new TTemplateTBS;
	
	//print_r($conf);
	return $tbs->render(TPL_HEADER,
		array(
			'menuTop'=>$conf->menu->top
			,'js'=>$conf->js
		)
		,array(
			'tpl'=>array('templateRoot'=>HTTP_TEMPLATE, 'id'=>'test', 'title'=>'test')
		)
	);
	
}
function _footer(&$conf) {
	$tbs=new TTemplateTBS;
	
	return $tbs->render(TPL_FOOTER,
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
