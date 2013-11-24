<?
/* Abreviation de translation
 * E : phrase
 * S : pĥrase traduite 
 */
function __tr($sentence) {
	global $conf;
	
	return TAtomic::translate($conf, $sentence);
	
}
function __tr_view($source) {
	$resultat='';
	$resultat .= preg_replace_callback(
		'|__tr\((.*?)\)__|'
		, create_function('$matches', 'return __tr($matches[1]);')
		,$source
	);
	
	return $resultat;
}
/*
 * Récupération de la langue du navigateur
 */
function GetLanguageCodeISO6391()
{
	$hi_code = '';
	$hi_quof = 0;
	$langs = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
	
	foreach($langs as $lang)
	{
		
		@list($codelang,$quoficient) = explode(';',$lang);
		if($quoficient == NULL) $quoficient = 1;
		if($quoficient > $hi_quof)
		{
			$hi_code = substr($codelang,0,2);
			$hi_quof = $quoficient;
		}
	}
	return $hi_code;
}
function _debug() {
	if(isset($_REQUEST['DEBUG'])) {
		return true;
	}
	
	return false;
}
function __get($varName, $default=null) {
	return isset($_REQUEST[$varName]) ? $_REQUEST[$varName] : $default;
} 
function __out($data) {
	
	if(isset($_REQUEST['gz'])) {
		$s = serialize($data);
		print gzdeflate($s,9);
	}
	elseif(isset($_REQUEST['gz2'])) {
		$s = serialize($data);
		print gzencode($s,9);
	}
	elseif(isset($_REQUEST['json'])) {
		print json_encode($data);
	}
	elseif(isset($_REQUEST['jsonp'])) {
			print $_GET['callback'].'('.json_encode($data).');' ;
	}
	else{
		$s = serialize($data);
		print $s;
	}

}