<?php
 

class TPhoto extends TObjetStd {
	function TPhoto(){
		$this->set_table(DB_PREFIX.'photo');
		$this->TChamps = array(); //tableau des champs é exploiter
		$this->_init_vars("theme,title,description,legend,source,filename");
		
		$this->start();
	
		
	}

	function loadFile($file){
		
	    if(is_string($file)){
	    	$file = urlencode($file);
			$image_name = date('Ymd_His').'_'.basename($file);
			if(!copy(strtr($file,$trans),DIR_IMGORIGINE.$image_name))return false;
		} else {
			$image_name = date("Ymd_His")."_"._url_format($file['name'], false, true);
			if(!copy($file['tmp_name'],DIR_IMGORIGINE.$image_name))return false;
		}
	
			$this->filename = $image_name;
			return true;
			
	}
 
}


