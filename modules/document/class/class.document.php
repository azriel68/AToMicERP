<?php
class TDocument extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'document');
		parent::add_champs('ref,type','type=chaine;index;');
		parent::add_champs('id_company,id_entity','type=entier;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
		
		$this->setChild('TDocumentLine', 'id_document');
		$this->setChild('TPaymentDocument', 'id_document');
	}
}

class TDocumentLine extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'document_line');
		parent::add_champs('title,description','type=chaine;');
		parent::add_champs('quantity, price, total','type=float;');
		parent::add_champs('id_document','type=entier;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}




