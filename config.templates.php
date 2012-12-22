<?
	/*
	 * 
	 * Définition des templates de l'interface
	 * 
	 */

	 
	
	 define('TEMPLATE_DIR',ROOT.'templates/');
	 define('THEME_TEMPLATE_DIR',TEMPLATE_DIR.THEME.'/');
	 
	 define('TPL_TIER',THEME_TEMPLATE_DIR.'tier.php');
	 define('TPL_HEADER',THEME_TEMPLATE_DIR.'header.php');
	 define('TPL_FOOTER',THEME_TEMPLATE_DIR.'footer.php');
	 

	require(THEME_TEMPLATE_DIR.'config.php');
