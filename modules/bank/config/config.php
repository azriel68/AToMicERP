<?php


	$conf->menu->top[] = array(
		'name'=>"Bank"
		,'id'=>'TBank'
		,'position'=>3
		,'url'=>HTTP.'modules/bank/'
		,'module'=>'bank'
	);

	
	$conf->modules['bank']=array(
		'name'=>'Bank'
		,'id'=>'TBank'
		,'icon'=>'119-piggy-bank.png'
	);
