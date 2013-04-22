<?php

class TPayment extends TObjetStd {
	function __construct() { 
		parent::set_table('payment');
		parent::add_champs('title,description','type=chaine;');
		parent::add_champs('amount','type=float;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
		
		$this->setChild('TPaymentDocument', 'id_payment');
	}
}

class TPaymentDocument extends TObjetStd {
	function __construct() { 
		parent::set_table('payment_document');
		parent::add_champs('amount','type=float;');
		parent::add_champs('id_document,id_payment','type=entier;index;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
	}
}
