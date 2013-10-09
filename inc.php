<?

	$conf = new stdClass;
	$conf->menu = new stdClass;
	
	$conf->menu->top = array();
	$conf->menu->left = array();
	$conf->modules = array();
	$conf->js = array();
	$conf->css = array();
	$conf->list = new stdClass;
	$conf->lang = array();
	$conf->rights = array();

	$conf->boxes=array();

	$conf->tabs = new stdClass;

	$conf->template = new stdClass;
	$conf->moduleCore = array(
		'core'=>true
		,'dictionary'=>true
		
		,'company'=>true
		,'contact'=>true
		,'user'=>true
	);

	if(is_file('config.php') && is_readable('config.php')) {
		require('config.php');
	}
	else {
		header('location:./install/');
		exit();
	}
	
	define('USE_TBS', true);
	require(COREROOT.'inc.core.php');
	require(ROOT.'includes/inc.php');
	
	session_name('atomic');
	session_start();

	$user = TAtomic::getUser();
	TAtomic::loadLang($conf, $user->lang);
	TAtomic::getConf($user);
	
	require('config.templates.php');
	TAtomic::loadStyle($conf, $user->theme);
	