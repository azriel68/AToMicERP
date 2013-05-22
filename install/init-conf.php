<?

require_once('../inc.php');

// Load csv file containing default values for conf
if(empty($company) && empty($_REQUEST['id_company'])) {
	echo 'Standard conf not created, company missing';
	return false;
}
$id_entity = empty($company) ? $_REQUEST['id_company'] : $company->getId();

$db = new TPDOdb;
$dir = ROOT.'modules/';
$file = 'standard-conf.conf';

$moduleToLoad = array_merge($conf->moduleCore, $conf->moduleEnabled);
foreach($moduleToLoad as $moduleName=>$options) {
	if(!empty($conf->modules[$moduleName])) {
		$path = $dir.$moduleName.'/config/';
		if(is_file($path.$file)) loadStdConf($path.$file, $id_entity);
	}
}

print "Standard conf loaded in database for entity ".$id_entity.'<br>';

function loadStdConf($filePath, $id_entity) {
	$fileHandler = fopen($file, 'r');
	while($dataline = fgetcsv($fileHandler, 1024)) {
		$config = new TConf;
		$config->id_entity = $id_entity;
		$config->confKey = $dataline[0];
		$config->confVal = $dataline[1];
		$config->save($db);
	}
	fclose($fileHandler);
}