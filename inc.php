<?

	$conf = new stdClass;
	$conf->menu = new stdClass;
	
	$conf->menu->top = array();
	$conf->menu->left = array();
	$conf->modules = array();
	$conf->js = array();
	$conf->list = new stdClass;
	$conf->lang = array();
	$conf->rigths = array();

	$conf->boxes=array();

	$conf->tabs = new stdClass;

	$conf->template = new stdClass;
	$conf->moduleCore = array(
		'dictionary'=>true
		
		,'company'=>true
		,'contact'=>true
		,'user'=>true
	);

	require('config.php');
	require('config.templates.php');
	
	define('USE_TBS', true);
	require(COREROOT.'inc.core.php');
	require(ROOT.'includes/inc.php');
	
	session_name('atomic');
	session_start();

	$user = TAtomic::getUser();
	TAtomic::loadLang($conf, $user->lang);