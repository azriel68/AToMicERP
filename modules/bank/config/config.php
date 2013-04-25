<?php


	$conf->menu->top[] = array(
		'name'=>"Banque"
		,'id'=>'TBank'
		,'position'=>3
		,'url'=>HTTP.'modules/bank/'
	);

	
	$conf->modules['bank']=array(
		'name'=>'Banque'
		,'id'=>'TBank'
	);
