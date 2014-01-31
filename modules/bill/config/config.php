<?php

/******************************************************************************************
 * Définition du module
 ******************************************************************************************/
$conf->modules['bill']=array(
	'name'=>'Bill'
	,'id'=>'TBill'
	,'class'=>array('TBill','TBillLine')
	,'folder'=>'bill'
	,'moduleRequire'=>array('user')
);

/******************************************************************************************
 * Définition des menus (top / left)
 ******************************************************************************************/
$conf->menu->top[] = array(
	'name'=>'Bills'
	,'id'=>'TBill'
	,'position'=>20
	,'url'=>HTTP.'modules/bill/bill.php'
);

/******************************************************************************************
 * Définition des onglet à afficher sur une fiche de l'objet
 ******************************************************************************************/
TTemplate::addTabs($conf, 'TBill' ,array(
	'card'=>array('label'=>'__tr(Card)__','url'=>HTTP.'modules/bill/bill.php?action=view&id=@id@')
	,'details'=>array('label'=>'__tr(Details)__','url'=>HTTP.'modules/bill/lines.php?action=view&id_bill=@id@')
));

/******************************************************************************************
 * Définition des templates à utiliser
 ******************************************************************************************/
@$conf->template->TBill->card = ROOT.'modules/bill/template/bill.html';
@$conf->template->TBill->lines = ROOT.'modules/bill/template/lines.html';

/******************************************************************************************
 * Définition de la conf par défaut du module
 ******************************************************************************************/
$conf->defaultConf['company'] = array(
	'TBill_autoref_ref_mask' => 'IN{yy}{mm}-{000}'
	,'TBill_autoref_ref_dateField' => 'dt_bill'
);

/******************************************************************************************
 * Définition des listes
 ******************************************************************************************/
@$conf->list->TBill->billList=array(
	'sql'=>"SELECT id, ref, dt_bill, status FROM ".DB_PREFIX."document WHERE id_entity IN (@getEntity@) AND type='bill' "
	,'param'=>array(
		'title'=>array(
			'ref'=>'__tr(Ref)__'
			,'dt_bill'=>'__tr(DateBill)__'
			,'status'=>'__tr(DateBill)__'
		)
		,'hide'=>array('id')
		,'type'=>array(
			'dt_bill'=>'date'
		)
		,'link'=>array(
			'ref'=>'<a href="'.HTTP.'modules/bill/bill.php?action=view&id=@id@">@val@</a>'
		)
	)
);
