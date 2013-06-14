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
@$conf->template->TPlanning = ROOT.'modules/planning/template/planning.html';