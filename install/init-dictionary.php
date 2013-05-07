<?

// Load csv files in dictionary/init folder and save it in database
if(empty($company)) {
	echo 'Dictionary not created';
	return false;
}
$id_entity = $company->getId();

$db = new TPDOdb;
$dir = ROOT.'modules/dictionary/init/';

$handle = opendir($dir); 
while (false !== ($file = readdir($handle))) {
	if($file!='.' && $file!='..'){
		$fileName = pathinfo($dir.$file, PATHINFO_FILENAME);
		$fileHandler = fopen($dir.$file, 'r');
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

print "Default dictionary loaded in database".'<br>';