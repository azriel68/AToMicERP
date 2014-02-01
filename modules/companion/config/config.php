<?php


	$conf->modules['companion']=array(
		'name'=>'companion'
		,'id'=>'TCompanion'
		,'class'=>array('TCompanion')
		,'moduleRequire'=>array('core')
	);

	TAtomic::addHook($conf
		, array('Notify','TProduct','Home') 
		,array(
			'function'=>'hook'
			,'object'=>'TCompanion'
			,'parameters'=>array()
		)
	);


	