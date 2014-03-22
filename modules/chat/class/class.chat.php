<?
class TChat extends TObjetStd {
	function __construct() {
		
		$this->set_table(DB_PREFIX.'chat');
		
		$this->addFields('message',array('type'=>'text'));
		$this->addFields('id_entity,id_user_from,id_user_to', array('type'=>'int', 'index'=>true));

		TAtomic::initExtraFields($this);
		
		$this->start();
		$this->_init_vars();
		
	}
}
