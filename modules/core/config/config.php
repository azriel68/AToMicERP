<?php

	$conf->modules['core']=array(
		'name'=>'Core'
		,'id'=>'Core'
		,'class'=>array('TNumbering', 'TConf')
	);
	
	$conf->js[] = HTTP.'modules/core/js/jquery-1.9.1.min.js';
	$conf->js[] = HTTP.'modules/core/js/jquery-ui.min.js';
	$conf->js[] = HTTP.'modules/core/js/jquery.dataTables.min.js';
	$conf->js[] = HTTP.'modules/core/js/jNotify.jquery.min.js';
	$conf->js[] = HTTP.'modules/core/js/tag-it.min.js';