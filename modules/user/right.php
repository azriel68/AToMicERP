<?php

require('../../inc.php');
	
if(!$user->isLogged()) {
	TTemplate::login($user);
}

$db=new TPDOdb;
$group = new TGroup;
$group->load($db, $_REQUEST['id_group']);

$TRight = array();
foreach($conf->rights as $right) {
	$TRight[] = array(
		'module'=>$right[0]
		,'submodule'=>$right[1]
		,'action'=>$right[2]
		,'status'=>($group->hasRight($right[0], $right[1], $right[2]) !== false) ? 'on' : 'off'
	);
}

$tbs=new TTemplateTBS;

print __tr_view($tbs->render(TTemplate::getTemplate($conf, $group, 'right')
	,array(
		'right'=>$TRight
	)
	,array(
		'group'=>$group->get_values()
		,'tpl'=>array(
			'header'=>TTemplate::header($conf)
			,'footer'=>TTemplate::footer($conf)
			,'menu'=>TTemplate::menu($conf, $user)
			,'tabs'=>TTemplate::tabs($conf, $user, $group, 'right')
			,'self'=>$_SERVER['PHP_SELF']
		)
	)
));

$db->close();