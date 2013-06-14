<?php

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$db=new TPDOdb;
$planning=new TPlanning;

$action = TTemplate::actions($db, $user, $planning);

if(!is_null($action)){
	//Actions
}
else{
	//Affichage du calendrier
	include("template/planning.html");
}

$db->close();