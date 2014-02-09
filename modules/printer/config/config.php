<?php

/******************************************************************************************
 * Définition du module
 ******************************************************************************************/
$conf->modules['printer']=array(
	'name'=>'Printer'
	,'id'=>'TPrinter'
	,'class'=>array('TPrinter')
	,'moduleRequire'=>array('core')
);

/******************************************************************************************
 * Définition des onglet à afficher sur une fiche de l'objet
 ******************************************************************************************/
TTemplate::addTabs($conf, 'TBill' ,array(
	'printer'=>array('label'=>'__tr(Print)__','url'=>HTTP.'modules/printer/print.php?action=view&id=@id@&object=TBill')
));
TTemplate::addTabs($conf, 'TOrder' ,array(
	'printer'=>array('label'=>'__tr(Print)__','url'=>HTTP.'modules/printer/print.php?action=view&id=@id@&object=TOrder')
));

@$conf->template->TPrinter->card = ROOT.'modules/printer/template/printer.html';
