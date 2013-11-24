<?php
/*
 * Script créant et vérifiant que les champs requis s'ajoutent bien
 *
 */

require ('../inc.php');

$db = new TPDOdb;

foreach (array_merge($conf->moduleCore, $conf->moduleEnabled) as $moduleName=>$options) {
	
	$module = $conf->modules[$moduleName];
	
	if (isset($module['class'])) {

		foreach ($module['class'] as $className) {

			print "Traitement de $className<br />";
			$o = new $className;
			if (method_exists($o, 'init_db_by_vars')) {
				$o -> init_db_by_vars($db);
			}

		}

	}

}
