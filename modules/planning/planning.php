<?php

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$db=new TPDOdb;
$db->debug = true;
$planning=new TPlanning;

$action = TTemplate::actions($db, $user, $planning);

if($action != false){
	//Actions
}
else{
	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $planning)
		,array()
		,array(
			'tpl'=>array(
				'header'=>TTemplate::header($conf)
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'self'=>$_SERVER['PHP_SELF']
			)
		)
	)); 
}

$db->close();