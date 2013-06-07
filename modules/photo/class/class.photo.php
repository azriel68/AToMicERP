<?php

class TPhoto extends TObjetStd {
	function TPhoto() {
			
		$this -> set_table(DB_PREFIX . 'photo');
		
		$this->add_champs('id_product','type=entier;index;');

		$this -> _init_vars("title,description,legend,source,filename");

		$this -> start();

	}
	function image($w=0, $h=0, $rotate=0) {
		
		//print $this->filename;
		$info = getimagesize($this->filename);
		$mime = $info['mime'];
		
		if($mime=='image/png') {
			$image = imagecreatefrompng ( $this->filename );	
		}
		elseif($mime=='image/jpeg') {
			$image = imagecreatefromjpeg ( $this->filename );	
		}
		elseif($mime=='image/gif') {
			$image = imagecreatefromgif ( $this->filename );	
		}
		else {
			return false;
		}
		
		if($rotate!=0) {
			$image=imagerotate($image, $rotate, 0);
		}
		
		
		header ('Content-Type: '.$mime);
		imagepng($image,null,9);
		imagedestroy($img);
		
	}
	function addFile($file, $typeObject, $idObject, $idEntity) {
		
		$dir = DOCROOT.$idEntity.'/'.$typeObject.'/'.$idObject.'/';
		@mkdir($dir, 0777, true);

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
