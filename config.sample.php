<?

	define('ROOT', '/var/www/ATM/AToMicERP/');
	define('HTTP', 'http://127.0.0.1/ATM/AToMicERP/');
	define('COREROOT', '/var/www/ATM/atm-core/');
	define('COREHTTP', 'http://127.0.0.1/ATM/atm-core/');

	define('DB_HOST','localhost');
	define('DB_NAME','atomicERP');
	define('DB_USER','root');
	define('DB_PASS','**********'); /* Your user password Here */
	define('DB_DRIVER','mysqli');

	define('THEME','atom');
	
	define('ADMIN','admin');
	
	/*
	 * Suite au prob de sens parsing répertoire, et temporairement jusqu'à prise de décision
	 */
	$conf->moduleEnabled=array(
		'address'=>true
		,'bank'=>true
		,'company'=>true
		,'contact'=>true
		,'document'=>true
		,'product'=>true
		,'user'=>true
	);