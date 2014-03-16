<?
class TCategory extends TObjetStd {
	function __construct() {
		
		parent::add_champs('label',array('type'=>'string', 'index'=>true));

		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
		
		$this->setChild('TCategoryLink', 'id_category');
		
	}
}

class TCategoryLink extends TObjetStd {
	function __construct() {
		
		parent::add_champs('id_category,id_object',array('type'=>'int', 'index'=>true));
		parent::add_champs('type_object',array('type'=>'string', 'index'=>true));

		TAtomic::initExtraFields($this);
		
		parent::start();
		parent::_init_vars();
		
		$this->category = new TCategory;
	}
	
	function load(&$db, $id) {
		parent::load($db, $id);
		
	}
	
}

