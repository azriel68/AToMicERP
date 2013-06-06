<?

require_once('../inc.php');

// Load default conf for each module
if(empty($company) && empty($_REQUEST['id_company'])) {
	echo 'Standard conf not created, company missing';
	return false;
}
$id_entity = empty($company) ? $_REQUEST['id_company'] : $company->getId();

$db = new TPDOdb;

$moduleToLoad = array_merge($conf->moduleCore, $conf->moduleEnabled);
foreach($moduleToLoad as $moduleName=>$options) {
	if(!empty($conf->modules[$moduleName]) && !empty($conf->defaultConf[$moduleName])) {
		foreach($conf->defaultConf[$moduleName] as $confKey => $confVal) {
			$config = new TConf;
			$config->id_entity = $id_entity;
			$config->confKey = $confKey;
			$config->confVal = $confVal;
			$config->save($db);
		}
	}
}

$db->close();

print "Standard conf loaded in database for entity ".$id_entity.'<br>';