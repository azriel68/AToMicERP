<?
/* Abreviation de translation
 * E : phrase
 * S : pĥrase traduite 
 */
function __tr($sentence) {
	global $conf;
	
	return TAtomic::translate($conf, $sentence);
	
}

/*
 * Récupération de la langue du navigateur
 */
function GetLanguageCodeISO6391()
{
	$hi_code = "";
	$hi_quof = 0;
	$langs = explode(",",$_SERVER['HTTP_ACCEPT_LANGUAGE']);
	foreach($langs as $lang)
	{
		list($codelang,$quoficient) = explode(";",$lang);
		if($quoficient == NULL) $quoficient = 1;
		if($quoficient > $hi_quof)
		{
			$hi_code = substr($codelang,0,2);
			$hi_quof = $quoficient;
		}
	}
	return $hi_code;
}
