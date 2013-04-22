<?php

class TAtomic {
	
	static function loadModule(&$conf) {
		
		$dir = ROOT.'modules/';
		$handle = readdir($dir); 
		
		while (false !== ($file = readdir($handle))) {
			set_time_limit(30);  
		   	if($file!='.' && $file!='..'){
				if(is_dir($dir.$file)){
						
					require($dir.$file.'/config/config.php');
					
					if(is_file($dir.$file.'/js/scripts.js')) $conf->js[]=HTTP.'modules/'.$file.'/js/scripts.js';
					if(is_file($dir.$file.'/lib/function.php')) require($dir.$file.'/lib/function.php');
					
					if(is_dir($dir.$file.'/class/')) {
						
						TAtomic::loadClass($conf, $dir.$file.'/class/');
						
					}
					
				}
			}
	   }
	   closedir($handle);
		
	}
	
	static function loadClass(&$conf, $dir) {
		$handle = readdir($dir); 
		
		while (false !== ($file = readdir($handle))) {
			set_time_limit(30);  
		   	if(substr($file,0,4)=='class'){
					require($dir.$file);
			}
	   }
	   closedir($handle);
	}
	
}
