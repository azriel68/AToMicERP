<?
/*
 * 
 * INTERFACE de communication pour la création / modification de Tier
 * 
 */


function tier(&$user, &$TTier, $id_tier = 0) {
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