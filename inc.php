<?

	$conf = new stdClass;
	$conf->menu = new stdClass;
	
	$conf->menu->top = array();
	$conf->menu->left = array();
	$conf->modules = array();
	$conf->js = array();
	$conf->list = array();

	$conf->template = new stdClass;

	require('config.php');
	require('config.templates.php');
	
	define('USE_TBS', true);
	require(COREROOT.'inc.core.php');
	require(ROOT.'includes/inc.php');


	session_name('atomic');
	session_start();
