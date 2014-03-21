<?
class TCategory extends TObjetStd {
	function __construct() {
		
		$this->set_table(DB_PREFIX.'category');
		
		$this->addFields('label',array('type'=>'string', 'index'=>true));
		$this->addFields('id_entity', array('type'=>'int', 'index'=>true));

		TAtomic::initExtraFields($this);
		
		$this->start();
		$this->_init_vars();
		
		$this->setChild('TCategoryLink', 'id_category');
		
	}
}

class TCategoryLink extends TObjetStd {
	function __construct() {
		$this->set_table(DB_PREFIX.'category_link');
		
		$this->addFields('id_category,id_object',array('type'=>'int', 'index'=>true));
		$this->addFields('objectType',array('type'=>'string', 'index'=>true));

		TAtomic::initExtraFields($this);
		
		$this->start();
		$this->_init_vars();
		
		$this->category = new TCategory;
	}
	
	function load(&$db, $id) {
		parent::load($db, $id);
		
	}
	
}

