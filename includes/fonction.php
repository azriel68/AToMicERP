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
