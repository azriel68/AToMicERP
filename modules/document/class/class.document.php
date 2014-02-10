<?php
class TDocument extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'document');
		parent::add_champs('ref,type','type=chaine;index;');
		parent::add_champs('id_company,id_entity','type=entier;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	
		if(get_class($this)=='TDocument') {
			$this->setChild('TDocumentLine', 'id_document', 'position ASC');
			$this->setChild('TPaymentDocument', 'id_document');
			
		}
		
		
	}
	
	function setOrderLine($TabName, $TPosition) {
		
		foreach($this->{$TabName} as &$line) {
			
			foreach($TPosition as $position=>$id) {
				if($id==$line->id) {
					$line->position = $position;	
					break;
				}
			}			
		}	
		
		$this->orderLineByPosition($TabName);
	}
	
	function orderLineByPosition($TabName) {
		usort($this->{$TabName}, array('TDocument', '_usort_order_by_position'));
	}
	
	static function _usort_order_by_position($a, $b) {
		if($a->position<$b->position) return -1;
		else if($a->position>$b->position) return 1;
		else return 0;
	}
	
	static function getListOfDoc(&$conf, $className, $id) {
		$Tab=array();
		
		return $Tab;	
	}
}

class TDocumentLine extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'document_line');
		parent::add_champs('title,description','type=chaine;');
		parent::add_champs('quantity, price, total,total_VAT,total_ATI,VAT_rate','type=float;');
		parent::add_champs('id_document','type=entier;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}




