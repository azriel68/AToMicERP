<?
class TProduct extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'product');
		parent::add_champs('id_entity','type=entier;');
		parent::add_champs('ref, label, description','type=chaine;');
		parent::add_champs('price','type=float;');
		parent::add_champs('dt_cre,dt_fin','type=date;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		
		parent::_init_vars();
		
		$this->setChild('TPrice','id_product');
	}
	static function getProductForCombo(&$db, $idEntities='') {
		$sql="SELECT id,label FROM ".DB_PREFIX."product WHERE 1";
		if(!empty($idEntities)) $sql.=' AND id_entity IN ('.$idEntities.') ';
		
		
		return TRequeteCore::get_keyval_by_sql($db, $sql, 'id', 'label');
	}
}

