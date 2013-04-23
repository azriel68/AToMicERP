<?php
/*
 * Script créant et vérifiant que les champs requis s'ajoutent bien
 *
 */
require ('../inc.php');

$db = new TPDOdb;

foreach ($conf->modules as $module) {
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
