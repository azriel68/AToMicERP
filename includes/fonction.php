<?
/* Abreviation de translation
 * E : phrase
 * S : pĥrase traduite 
 */
function __tr($sentence) {
	global $conf;
	
	return TAtomic::translate($conf, $sentence);
	
}
