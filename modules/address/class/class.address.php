<?php

class TAddress extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'address');
		parent::add_champs('id_contact,id_company,isDefaultBilling,isDefaultShipping','type=entier;index;');
		parent::add_champs('name,address,zip,city,country','type=chaine;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
		
		$this->country = DEFAULT_COUNTRY;
	}
	
	function save(&$db) {
		if($this->isDefaultBilling == 1) {
			$sql = "UPDATE ".$this->get_table()." SET isDefaultBilling = 0 ";
			$sql.= "WHERE id_contact = ".$this->id_contact." AND id_company = ".$this->id_company;
			$db->Execute($sql);
		}
		
		if($this->isDefaultShipping == 1) {
			$sql = "UPDATE ".$this->get_table()." SET isDefaultShipping = 0 ";
			$sql.= "WHERE id_contact = ".$this->id_contact." AND id_company = ".$this->id_company;
			$db->Execute($sql);
		}
		
		parent::save($db);
	}
}

