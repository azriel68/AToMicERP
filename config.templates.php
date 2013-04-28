<?
	/*
	 * 
	 * Définition des templates de l'interface
	 * 
	 */

	 
	
	 define('TEMPLATE_DIR',ROOT.'templates/');
	 define('THEME_TEMPLATE_DIR',TEMPLATE_DIR.THEME.'/');
	 define('DEFAULT_TEMPLATE_DIR',TEMPLATE_DIR.'default/');
	 
	 define('TPL_HEADER',is_file(THEME_TEMPLATE_DIR.'header.html') ? THEME_TEMPLATE_DIR.'header.html' : DEFAULT_TEMPLATE_DIR.'header.html' );
	 define('TPL_FOOTER',is_file(THEME_TEMPLATE_DIR.'footer.html') ? THEME_TEMPLATE_DIR.'footer.html' : DEFAULT_TEMPLATE_DIR.'footer.html' );
	 define('TPL_MENU',is_file(THEME_TEMPLATE_DIR.'menu.html') ? THEME_TEMPLATE_DIR.'menu.html' : DEFAULT_TEMPLATE_DIR.'menu.html' );
	 define('TPL_TABS',is_file(THEME_TEMPLATE_DIR.'tabs.html') ? THEME_TEMPLATE_DIR.'tabs.html' : DEFAULT_TEMPLATE_DIR.'tabs.html' );
	 
	 define('HTTP_TEMPLATE', HTTP.'templates/'.THEME.'/'); 

	 @$conf->template->home->fiche = THEME_TEMPLATE_DIR.'home.html';	 
	 @$conf->template->login->fiche = THEME_TEMPLATE_DIR.'login.html';