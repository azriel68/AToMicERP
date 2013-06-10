<?
class TBill extends TDocument {
	function __construct() {
		parent::add_champs('status','type=chaine;index;');
		parent::add_champs('ref_ext','type=chaine;');
		parent::add_champs('dt_bill','type=date;');
		
		parent::__construct();
	}
	
	function save(&$db) {
		if(empty($this->ref)) {
			$this->ref = TNumbering::getNextRefValue($db, $this, 'ref');
		}
		
		return parent::save($db);
	}
}