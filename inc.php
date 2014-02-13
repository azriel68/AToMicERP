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

	if(is_file(__DIR__.'/config.php') && is_readable(__DIR__.'/config.php')) {
		require(__DIR__.'/config.php');
	}
	else if(!empty($_FOR_INSTALLER)) {
		print 'Using sample config, only for install';
		require('config.sample.php');
		
	}
	else {
		header('location:./install/');
		exit();
	}
	
	require(ROOT.'includes/inc.php');


	$db=new TPDOdb;
		
	if(empty($_FOR_INSTALLER)) {
		TAtomic::loadModule($db, $conf);
		TAtomic::sortMenu($conf);
	}


	
	session_name('atomic');
	session_start();

	if(empty($_FOR_SCRIPT)) {
		
		$user = TAtomic::getUser($db);
		TAtomic::loadLang($conf, $user->lang);
		
		if(empty($_FOR_INSTALLER)) TAtomic::getConf($db, $user);
		
		require('config.templates.php');
		TAtomic::loadStyle($conf, $user->theme);
	}
	
	TAtomic::accesslog('page '.$_SERVER['PHP_SELF'].$_SERVER['REQUEST_URI']);
	