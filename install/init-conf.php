<?

require_once('../inc.php');

// Load csv file containing default values for conf
if(empty($company) && empty($_REQUEST['id_company'])) {
	echo 'Standard conf not created, company missing';
	return false;
}
$id_entity = empty($company) ? $_REQUEST['id_company'] : $company->getId();

$db = new TPDOdb;
$dir = ROOT.'install/';
$file = 'standard-conf.conf';

$fileHandler = fopen($dir.$file, 'r');
while($dataline = fgetcsv($fileHandler, 1024)) {
	$conf = new TConf;
	$conf->id_entity = $id_entity;
	$conf->confKey = $dataline[0];
	$conf->confVal = $dataline[1];
	$conf->save($db);
}
fclose($fileHandler);

print "Standard conf loaded in database for entity ".$id_entity.'<br>';