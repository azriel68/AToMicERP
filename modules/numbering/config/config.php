<?php

	$conf->modules['numbering']=array(
		'name'=>'Numbering'
		,'id'=>'numbering'
		,'class'=>array('TNumbering')
	);

	TTrigger::register('TNumbering',50);
	