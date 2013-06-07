<?php

class TPhoto extends TObjetStd {
	function TPhoto() {
			
		$this -> set_table(DB_PREFIX . 'photo');
		
		$this->add_champs('id_product','type=entier;index;');

		$this -> _init_vars("title,description,legend,source,filename");

		$this -> start();

	}

	function addFile($file, $typeObject, $idObject, $idEntity) {
		
		$dir = DOCROOT.$idEntity.'/'.$typeObject.'/'.$idObject.'/';
		@mkdir($dir, 777, true);

		if (is_string($file)) {
			$file = urlencode($file);
			$image_name = date('Ymd_His') . '_' . basename($file);
			if (!copy(strtr($file, $trans), $dir . $image_name))
				return false;
		} else {
			$image_name = date("Ymd_His") . "_" . _url_format($file['name'], false, true);
			if (!copy($file['tmp_name'], $dir . $image_name))
				return false;
		}

		$this -> filename = $dir.$image_name;
		return true;

	}

}
