<?
/*
 * 
 * INTERFACE de communication pour la création / modification de Tier
 * 
 */

 if(isset($_REQUEST['get'])) {
 	_get($_REQUEST['get']);	
 }
 
 if(isset($_REQUEST['put'])) {
 	
 }
 
function _get($case) {
	switch ($case) {
		case 'tier':
			return _out(tier($user, $_REQUEST['id'])); 	
			break;
		
		
		default:
			
			break;
	}
	
	
} 
function _out($data) {
	
	if(isset($_REQUEST['gz'])) {
		$s = serialize($data);
		print gzdeflate($s,9);
	}
	elseif(isset($_REQUEST['gz2'])) {
		$s = serialize($data);
		print gzencode($s,9);
	}
	elseif(isset($_REQUEST['json'])) {
		print json_encode($data);
	}
	else{
		$s = serialize($data);
		print $s;
	}

}		 
function tier(&$user, $id_tier) {
	$db=new Tdb;
	
	$t=new TTier;
	
	$t->load($db, $id_tier); 
	
	$db->close();
	
	return $t->get_tab();
	
} 

function saveTier(&$user, &$TTier, $id_tier = 0) {
	$db=new Tdb;
	
	$t=new TTier;
	
	if($id_tier>0) $t->load($db, $id_tier); 
	
	$t->set_values($TTier);
	$t->save($db, ($id_tier==0) ? "Création du tier": "Modification du tier");
	
	$db->close();
}
function addContact(&$TContact, $id_tier) {
	
	$db=new Tdb;
	
	$t=new TTier;
	
	$t->addContact($TContact);
	
	$t->save($db, "Ajout d'un contact");
	
	$db->close();
	
}

?>