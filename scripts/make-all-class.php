<?
	require('../inc.php');
	$dbname = DB_NAME;

	$db=new Tdb;
	$db->Execute('SHOW TABLES FROM '.$dbname);
	$Tab=array();
	while($db->Get_line()) {
//print_r($db);
		$Tab[] = $db->Get_field('Tables_in_'.$dbname);	
	}	
	
	foreach($Tab as $table) {
		$t = new TSSObjet($db,  $table);
		$t->view_file_source();

	}

	
	$db->close();
?>
