<?
class TTier extends TObjetStd {
	function __construct() { 
		parent::set_table('atm_tier');
		parent::add_champs('nom','type=entier;');
		parent::add_champs('adresse,telephone,fax,cp,ville','type=chaine;');
		parent::start();
		parent::_init_vars();
	}
}
?>
