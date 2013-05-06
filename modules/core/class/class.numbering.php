<?
class TNumbering extends TObjetStd {
	function __construct() {
		
		parent::set_table(DB_PREFIX.'numbering');
		
		parent::add_champs('id_entity','type=entier;index;');
		parent::add_champs('numberValue','type=entier;index;');
		parent::add_champs('module,mask','type=chaine;');
		
		TAtomic::initExtraFields($this);

		parent::start();
		parent::_init_vars();
	}
	
	static function getNextRefValue(&$db, &$user, $module, $date, $mask='', $status=0) {
		if($status == 0) {
			//return '(DRAFT'.$object->getID().')';
		}
		if($mask == '') {
			//return $object->getID();
		}
		if(empty($date)) $date = time();
		
		$maskToSearch = $mask;
		
		// Remplacement des variables de date
		$maskToSearch = preg_replace('|{yy}|', date('y', $date), $maskToSearch);
		$maskToSearch = preg_replace('|{yyyy}|', date('Y', $date), $maskToSearch);
		$maskToSearch = preg_replace('|{mm}|', date('m', $date), $maskToSearch);
		$maskToSearch = preg_replace('|{dd}|', date('d', $date), $maskToSearch);
		
		$params = array(
			'module' => $module
			,'id_entity' => $user->id_entity
			,'mask' => $maskToSearch
		);
		
		$num = new TNumbering;
		$TNum = TRequeteCore::get_id_from_what_you_want($db, $num->get_table(), $params);
		if(!empty($TNum[0])) {
			$num->load($db, $TNum[0]);
		} else {
			$num->module = $module;
			$num->id_entity = $user->id_entity;
			$num->mask = $maskToSearch;
			$num->numberValue = 0;
		}
		
		$num->numberValue++;
		$num->save($db);
		
		preg_match('|{0.*?}|', $maskToSearch, $matche);
		$ref = preg_replace('|{0.*?}|', str_pad($num->numberValue, strlen($matche[0])-2, '0', STR_PAD_LEFT), $maskToSearch);
		
		return $ref;
	}
}