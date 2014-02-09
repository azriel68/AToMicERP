<?
class TBill extends TDocument {
	function __construct() {
		parent::add_champs('status','type=chaine;index;');
		parent::add_champs('ref_ext','type=chaine;');
		parent::add_champs('dt_bill','type=date;');

		parent::add_champs('total,total_VAT,total_ATI','type=float;'); //ATI All taxe included

		
		parent::__construct();
		
		$this->type='bill';
		
		$this->setChild('TBillLine', 'id_document', 'position ASC');
		
	}	
}

class TBillLine extends TDocumentLine {
	function __construct() { 
		
		parent::add_champs('id_product','type=entier;index;');
		parent::__construct();
		
	}
}

