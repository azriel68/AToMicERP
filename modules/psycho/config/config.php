<?php


	$conf->modules['psycho']=array(
		'name'=>'psycho'
		,'id'=>'TPsycho'
		,'class'=>array('TPsycho')
		,'moduleRequire'=>array('project')
	);

	TAtomic::addHook($conf, 'TContact',array(
		'function'=>'hook'
		,'object'=>'TPsycho'
		,'parameters'=>array()
	));


	