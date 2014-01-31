<?php


	$conf->modules['companion']=array(
		'name'=>'companion'
		,'id'=>'TCompanion'
		,'class'=>array('TCompanion')
		,'moduleRequire'=>array('core')
	);

	TAtomic::addHook($conf, 'Notify',array(
		'function'=>'hook'
		,'object'=>'TCompanion'
		,'parameters'=>array()
	));


	