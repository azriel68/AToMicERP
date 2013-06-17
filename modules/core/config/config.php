<?php

	$conf->modules['core']=array(
		'name'=>'Core'
		,'id'=>'Core'
		,'class'=>array('TNumbering', 'TConf')
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
	
	$conf->js[] = HTTP.'modules/core/js/jquery.alert.js';
	$conf->js[] = HTTP.'modules/core/js/jquery.colorselect.js';
	$conf->js[] = HTTP.'modules/core/js/jquery.datepicker.js';
	$conf->js[] = HTTP.'modules/core/js/datepicker_lang_FR.js';
	$conf->js[] = HTTP.'modules/core/js/jquery.dropdown.js';
	$conf->js[] = HTTP.'modules/core/js/jquery.form.js';
	$conf->js[] = HTTP.'modules/core/js/jquery.ifrmdailog.js';
	$conf->js[] = HTTP.'modules/core/js/jquery.validate.js';
	
	
	//CSS
	$conf->css[] = HTTP.'modules/core/css/alert.css';
	$conf->css[] = HTTP.'modules/core/css/colorselect.css';
	$conf->css[] = HTTP.'modules/core/css/dailog.css';
	$conf->css[] = HTTP.'modules/core/css/dp.css';
	$conf->css[] = HTTP.'modules/core/css/dropdown.css';
	$conf->css[] = HTTP.'modules/core/css/Error.css';
	$conf->css[] = HTTP.'modules/core/css/main.css';
