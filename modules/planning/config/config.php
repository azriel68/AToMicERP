<?php
/******************************************************************************************
 * Définition du module
 ******************************************************************************************/
$conf->modules['planning']=array(
	'name'=>'Planning'
	,'id'=>'planning'
	,'class'=>array('TPlanning')
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
 *******************************************************************************************/
$conf->js[] = HTTP.'modules/planning/js/Common.js';
$conf->js[] = HTTP.'modules/planning/js/jquery.calendar.js';
$conf->js[] = HTTP.'modules/planning/js/wdCalendar_lang_FR.js';

/******************************************************************************************
 * Définition des css 
 *******************************************************************************************/
$conf->css[] = HTTP.'modules/planning/css/calendar.css';

