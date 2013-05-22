<?php
class TDictionary extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'dictionary');
		parent::add_champs('id_entity,valid','type=entier;index;');
		parent::add_champs('label','type=chaine;');
		parent::add_champs('code,type','typeconf=chaine;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
	
	static function get(&$db, &$user, $id_entity, $type, $code='') {
		// Si pas d'entity, on prend l'entité par défaut du user, voir à stocker dans un cookie / session si l'utilisateur choisi une autre entité
		if($id_entity == 0) $id_entity = $user->id_entity;
		
		if(isset($user->dictionary[$id_entity][$type])) { // Dictionnaire déjà chargé dans la session utilisateur
			$TDictionnary= & $user->dictionary[$id_entity][$type];
		} else {
			// Récupération du dictionnaire
			$TDictionnary = TRequeteCore::get_keyval_by_sql($db, "SELECT code, label FROM ".DB_PREFIX."dictionary WHERE id_entity = ".$id_entity." AND valid = 1 AND type='".$type."'", 'code', 'label');

			// Traduction et tri
			foreach($TDictionnary as $key=>$value) {
				$TDictionnary[$key] = __tr($value);
			}
			natsort($TDictionnary);
			
			// Stockage en session
			$user->dictionary[$id_entity][$type] = $TDictionnary;
		}
		
		return empty($code) ? $TDictionnary : $TDictionnary[$code];
	}
	static function set(&$db, $type, $code) {
				
			
		
	}
}

