<?

	define('ROOT', __DIR__.'/');
	define('HTTP', '@HTTP@');
	define('DOCROOT', ROOT.'documents/');
	
	define('DB_HOST','@DB_HOSTNAME@');
	define('DB_NAME','@DB_BASENAME@');
	define('DB_USER','@DB_USER@');
	define('DB_PASS','@DB_USER_PASSWORD@'); /* Your user password Here */
	define('DB_DRIVER','mysql');
	define('DB_PREFIX','@DB_PREFIX@');

	define('DEFAULT_THEME','atom');
	define('DEFAULT_LANG','fr_FR');
	define('DEFAULT_COUNTRY', 'FR');
	define('ATOMIC_LOGO','AToMic ERP');

	define('ADMIN','admin');
	
	date_default_timezone_set('Europe/Paris'); 
	
	/*
	 * Suite au prob de sens parsing répertoire, et temporairement jusqu'à prise de décision
	 */
	@$conf->moduleEnabled=array(
		'address'=>true
		,'bank'=>true
		,'company'=>true
		,'contact'=>true
		,'document'=>true
		,'bill'=>true
		,'product'=>true
		,'user'=>true
		,'dictionary'=>true
		,'project'=>true
		,'planning'=>true
		,'currency'=>true
		,'wallpaper'=>true
	);