<?

	define('ROOT', '/var/www/ATM/AToMicERP/');
	define('HTTP', 'http://127.0.0.1/ATM/AToMicERP/');

	define('DB_PREFIX','atm_');
	define('DB_HOST','localhost');
	define('DB_BASE','atomicERP');
	define('DB_USER','ROOT');
	define('DB_PASS','**********'); /* Your user password Here */

	define('THEME','atom');
	
	require('config.templates.php');
	
	require(ROOT.'includes/inc.php');
	
?>
