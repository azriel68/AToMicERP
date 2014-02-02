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
	
	static function getNextRefValue(&$db, &$object, $field) {
		$module = get_class($object);
		
		// Get conf for the mask
		$confMask = $module.'_autoRef_'.$field.'_mask';
		$mask = TConf::get($db, $object->id_entity, $confMask);
		if($mask === false) return false;
		
		// Get conf for the date field
		$confDateField = $module.'_autoRef_'.$field.'_dateField';
		$dateField = TConf::get($db, $object->id_entity, $confDateField);
		if($dateField === false) return false;
		
		$date = !empty($object->{$dateField}) ? $object->{$dateField} : time();
		$maskToSearch = $mask;
		
		// Remplacement des variables de date
		$maskToSearch = preg_replace('|{yy}|', date('y', $date), $maskToSearch);
		$maskToSearch = preg_replace('|{yyyy}|', date('Y', $date), $maskToSearch);
		$maskToSearch = preg_replace('|{mm}|', date('m', $date), $maskToSearch);
		$maskToSearch = preg_replace('|{dd}|', date('d', $date), $maskToSearch);
		
		$params = array(
			'module' => $module
			,'id_entity' => $object->id_entity
			,'mask' => $maskToSearch
		);
		
		$num = new TNumbering;
		$TNum = TRequeteCore::get_id_from_what_you_want($db, $num->get_table(), $params);
		if(!empty($TNum[0])) {
			$num->load($db, $TNum[0]);
		} else {
			$num->module = $module;
			$num->id_entity = $object->id_entity;
			$num->mask = $maskToSearch;
			$num->numberValue = 0;
		}
		
		$num->numberValue++;
		$num->save($db);
		
		preg_match('|{0.*?}|', $maskToSearch, $matches);
		if(!empty($matches)) {
			$ref = preg_replace('|{0.*?}|', str_pad($num->numberValue, strlen($matches[0])-2, '0', STR_PAD_LEFT), $maskToSearch);
			
		}
		else {
			$ref=''; // TODO to debug
		}
		
		return $ref;
	}

	static function trigger(&$db, &$object, $className, $state) {
		if($className=='TBill' && ($state == 'before_create' || $state=='before_update' )) {
			
			if(empty($object->ref)) {
				$object->ref = TNumbering::getNextRefValue($db, $object, 'ref');
			}			
		}
		else if($className=='TCompany' && ($state == 'before_create' || $state=='before_update' )) {
			
			if(empty($object->customerRef) && $object->isCustomer == 1) {
				$object->customerRef = TNumbering::getNextRefValue($db, $object, 'customerRef');
			}
			
			// Set supplier Ref
			if(empty($object->supplierRef) && $object->isSupplier == 1) {
				$object->supplierRef = TNumbering::getNextRefValue($db, $object, 'supplierRef');
			}
			
		}
	}
}