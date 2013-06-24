<?php

class TCurrency extends TObjetStd {
	
	function __construct() {
		
		parent::set_table(DB_PREFIX.'currency');
		
		parent::add_champs('code,name','type=chaine;index;');
		
		TAtomic::initExtraFields($this);

		parent::start();
		parent::_init_vars();

		$this -> setChild('TCurrencyRate', 'id_currency');
		
	}
	
	function loadByCode(&$db, $code) {
		
		return $this->loadBy($db, $code, 'code');
		
	}
	
	function addRate($rate, $date='') {
		if(empty($date))$date = date('Y-m-d');
		foreach($this->TCurrencyRate as &$rate) {
			if($rate->get_date('dt_sync','Y-m-d') == $date) {
				return false;
			}
		}
		
		$k = $this->addChild($db, 'TCurrencyRate');
		
		$this->TCurrencyRate[$k]->rate = $rate;
		$this->TCurrencyRate[$k]->dt_sync = strtotime($date);
		
	}
	
	static function getRate(&$db, $code, $date='') {
		
		if(empty($date))$date = date('Y-m-d');
		
		$db->Execute("SELECT rate 
		FROM ".DB_PREFIX."currency_rate cr INNER JOIN ".DB_PREFIX."currency c ON (cr.id_currency=c.id)
		WHERE c.code = '".$code."' AND cr.dt_sync>='".$date."'
		ORDER BY cr.dt_sync DESC
		LIMIT 1
		");
		
		$db->Get_line();
		
		return (double)$db->Get_field('rate');
		
	} 
	
	static function getPrice(&$db, $code, $price, $date='') {
		
		if(empty($date))$date = date('Y-m-d');
		
		$rate = TCurrency::getPrice($db, $code, $date);
		
		return $price * $rate;
		
	}
	
}

class TCurrencyRate extends TObjetStd {
	
	function __construct() {
		
		parent::set_table(DB_PREFIX.'currency_rate');
		
		parent::add_champs('rate','type=float;');
		parent::add_champs('id_currency','type=entier;index;');
		parent::add_champs('dt_sync','type=date;index;');
		
		TAtomic::initExtraFields($this);

		parent::start();
		parent::_init_vars();
		
	}
	
}
