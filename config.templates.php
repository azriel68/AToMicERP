<?
	/*
	 * 
	 * Définition des templates de l'interface
	 * 
	 */

	 
	
	 define('TEMPLATE_DIR',ROOT.'templates/');
	 define('THEME_TEMPLATE_DIR',TEMPLATE_DIR.THEME.'/');
	 
	 define('TPL_HEADER',THEME_TEMPLATE_DIR.'header.html');
	 define('TPL_FOOTER',THEME_TEMPLATE_DIR.'footer.html');
	
	 define('HTTP_TEMPLATE', HTTP.'templates/'.THEME.'/'); 

	 @$conf->template->home->fiche = THEME_TEMPLATE_DIR.'home.html';	 
	 @$conf->template->login->fiche = THEME_TEMPLATE_DIR.'login.html';