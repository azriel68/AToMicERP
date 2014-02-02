<?php

	$conf->modules['core']=array(
		'name'=>'Core'
		,'id'=>'Core'
		,'class'=>array('TNumbering', 'TConf'/*,'TListviewTBS'*/,'TReponseMail')
	);
	
	//JAVASCRIPTS
	$conf->js[] = HTTP.'modules/core/js/jquery-1.9.1.min.js';
	$conf->js[] = HTTP.'modules/core/js/jquery-ui.min.js';
	$conf->js[] = HTTP.'modules/core/js/jquery.dataTables.min.js';
	$conf->js[] = HTTP.'modules/core/js/jNotify.jquery.min.js';
	$conf->js[] = HTTP.'modules/core/js/tag-it.min.js';
	$conf->js[] = HTTP.'modules/core/js/jquery.cookie.js';

	$conf->js[] = HTTP.'modules/core/js/highcharts/highcharts.js';
	$conf->js[] = HTTP.'modules/core/js/highcharts/highcharts-more.js';
	
	$conf->js[] = HTTP.'modules/core/js/list.tbs.js';

	$conf->js[] = HTTP.'modules/core/js/jquery.validate.min.js';


	TTrigger::register('TNumbering');
	