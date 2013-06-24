<?php
/******************************************************************************************
 * Définition du module
 ******************************************************************************************/
$conf->modules['planning']=array(
	'name'=>'Planning'
	,'id'=>'planning'
	,'class'=>array('TPlanning','TEvent','TStatus')
	,'folder'=>'planning'
	,'icon'=>'83-calendar.png'
);

/******************************************************************************************
 * Définition des menus (top / left)
 ******************************************************************************************/
$conf->menu->top[] = array(
	'name'=>'Planning'
	,'id'=>'TPlanning'
	,'module'=>'planning'
	,'position'=>5
	,'url'=>HTTP.'modules/planning/planning.php'
);

/******************************************************************************************
 * Définition des templates à utiliser
 ******************************************************************************************/
@$conf->template->TPlanning->card = ROOT.'modules/planning/template/planning.html';

/******************************************************************************************
 * Définition des js 
 ******************************************************************************************/
$conf->js[] = HTTP.'modules/planning/js/colorpicker/colorpicker.js';
$conf->js[] = HTTP.'modules/planning/js/jquery-qtip-1.0.0-rc3140944/jquery.qtip-1.0.js';
$conf->js[] = HTTP.'modules/planning/js/lib/jshashtable-2.1.js';
$conf->js[] = HTTP.'modules/planning/js/frontierCalendar/jquery-frontier-cal-1.3.2.js';
 
/******************************************************************************************
 * Définition des css 
 ******************************************************************************************/
$conf->css[] = HTTP.'modules/planning/css/frontierCalendar/jquery-frontier-cal-1.3.2.css';
$conf->css[] = HTTP.'modules/planning/css/colorpicker/colorpicker.css';
