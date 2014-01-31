<?
class TProduct extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'product');
		parent::add_champs('id_entity','type=entier;');
		parent::add_champs('ref, label, description','type=chaine;');
		parent::add_champs('price_ht,vat_rate,packaging','type=float;'); // TODO price_ht -> price ?
		parent::add_champs('dt_start,dt_end','type=date;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		
		parent::_init_vars();
		
		$this->setChild('TPrice','id_product');
	}
	static function getProductForCombo(&$db, $idEntities='') {
		$sql="SELECT id,CONCAT('[',ref,'] ',label) as label FROM ".DB_PREFIX."product WHERE 1";
		if(!empty($idEntities)) $sql.=' AND id_entity IN ('.$idEntities.') ';
		
		
		return TRequeteCore::get_keyval_by_sql($db, $sql, 'id', 'label');
	}
	
	/*
	 * Return the current price
	 * Param to add : date, qty, packaging, etc
	 */
	function price($date='') {
		
		$time = empty($date) ? time() : strtotime($date);
		
		foreach($this->TPrice as &$price) {
			
			if($price->dt_start>=$time && $price->dt_end<=$time ) {
				return $price->price_ht;
			}
			
		}
		
		return $this->price_ht;
		
	}
	static function getPrice(&$db, $id_product, $date='') {
		$p=new TProduct;
		$p->load($db, $id_product);
		
		return $p->price();
	}
}

