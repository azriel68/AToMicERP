<?
	/*
	 * 
	 * Définition des templates de l'interface
	 * 
	 */

	 
	 if(!empty($user) || !is_dir(ROOT.'templates/'.$user->theme.'/')) {
	 	$user->theme = DEFAULT_THEME;
	 } 
	 	
	 define('TEMPLATE_DIR',ROOT.'templates/');
	 define('THEME_TEMPLATE_DIR',TEMPLATE_DIR.$user->theme.'/');
	 define('DEFAULT_TEMPLATE_DIR',TEMPLATE_DIR.'default/');

	 define('TPL_HEADER',is_file(THEME_TEMPLATE_DIR.'header.html') ? THEME_TEMPLATE_DIR.'header.html' : DEFAULT_TEMPLATE_DIR.'header.html' );
	 define('TPL_FOOTER',is_file(THEME_TEMPLATE_DIR.'footer.html') ? THEME_TEMPLATE_DIR.'footer.html' : DEFAULT_TEMPLATE_DIR.'footer.html' );
	 define('TPL_MENU',is_file(THEME_TEMPLATE_DIR.'menu.html') ? THEME_TEMPLATE_DIR.'menu.html' : DEFAULT_TEMPLATE_DIR.'menu.html' );
	 define('TPL_TABS',is_file(THEME_TEMPLATE_DIR.'tabs.html') ? THEME_TEMPLATE_DIR.'tabs.html' : DEFAULT_TEMPLATE_DIR.'tabs.html' );
	
	
	  
	 define('HTTP_TEMPLATE', HTTP.'templates/'.$user->theme.'/');	 

	 @$conf->template->home->card = THEME_TEMPLATE_DIR.'home.html';	 
	 @$conf->template->login->card = THEME_TEMPLATE_DIR.'login.html';
	 
	 define('ATOMIC_LOGO','<img src="'.HTTP_TEMPLATE.'images/logo.png" />'); //TODO define in entity
	 