<?php
class TPlanning extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'planning');
		parent::add_champs('id_entity','type=entier;');
		parent::add_champs('label','type=chaine;');
		parent::add_champs('dt_cre,dt_fin','type=date;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		
		parent::_init_vars();
	}
}

class TEvent extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'event');
		parent::add_champs('id_entity, id_status, id_planning','type=entier;');
		parent::add_champs('label, note, bgcolor, txtcolor','type=chaine;');
		parent::add_champs('dt_cre,dt_deb,dt_fin','type=date;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		
		parent::_init_vars();
	}
}

class TStatus extends TObjetStd {
	function __construct() { 
		parent::set_table(DB_PREFIX.'event_status');
		parent::add_champs('id_entity','type=entier;');
		parent::add_champs('label','type=chaine;');
		parent::add_champs('dt_cre','type=date;');
		
		TAtomic::initExtraFields($this);
		
		parent::start();
		
		parent::_init_vars();
	}
}