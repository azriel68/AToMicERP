<?

require_once('../inc.php');

// Load csv files in dictionary/init folder and save it in database
if(empty($company) && empty($_REQUEST['id_company'])) {
	echo 'Dictionary not created, company missing';
	return false;
}
$id_entity = empty($company) ? $_REQUEST['id_company'] : $company->getId();

$db = new TPDOdb;
$dir = ROOT.'modules/dictionary/init/';

$handle = opendir($dir); 
while (false !== ($file = readdir($handle))) {
	if($file!='.' && $file!='..'){
		$fileName = pathinfo($dir.$file, PATHINFO_FILENAME);
		$fileHandler = fopen($dir.$file, 'r');
		
		$db->Execute("DELETE FROM ".DB_PREFIX."dictionary WHERE id_entity=".$id_entity." AND type='".$fileName."'");
		
		while($dataline = fgetcsv($fileHandler, 1024)) {
			$dic = new TDictionary;
			$dic->id_entity = $id_entity;
			$dic->valid = 1;
			$dic->type = $fileName;
			$dic->code = $dataline[0];
			$dic->label = $dataline[1];
			$dic->save($db);
		}
		fclose($fileHandler);
	}
}
closedir($handle);

$db->close();

print "Default dictionaries loaded in database for entity ".$id_entity.'<br>';