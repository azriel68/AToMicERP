<?

	define('OBJETSTD_MASTERKEY', 'id');
	define('OBJETSTD_DATECREATE', 'dt_cre');
	define('OBJETSTD_DATEUPDATE', 'dt_maj');
	define('OBJETSTD_DATEMASK', 'dt_');

	/*
	 * Inclusion des classes & non standart ci-après
	 */
	require('fonction.php');
	 
	require('class.form.core.php');
	require('class.tools.php');
	require('class.trigger.php');
	require('class.objet_std.php');
	require('class.pdo.db.php');
	require('class.requete.core.php');
	
	require('class.requete.php');
	require('class.atomic.php');

	require('tbs_class.php');
	require('tbs_plugin_opentbs.php');
	
	require('class.template.tbs.php');
	require('class.template.php');
	
	TAtomic::loadModule($conf);
	TAtomic::sortMenu($conf);
	