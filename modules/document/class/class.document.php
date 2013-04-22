<?php
class TDocument extends TObjetStd {
	function __construct() { 
		parent::set_table('document');
		parent::add_champs('number','type=chaine;');
		parent::add_champs('id_company','type=entier;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
		
		$this->setChild('TDocumentLigne', 'id_document');
		$this->setChild('TPaymentDocument', 'id_document');
	}
}

class TDocumentLigne extends TObjetStd {
	function __construct() { 
		parent::set_table('document_ligne');
		parent::add_champs('title,description','type=chaine;');
		parent::add_champs('quantity, price, total','type=float;');
		parent::add_champs('id_document','type=entier;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}




