<?php



	
	$conf->modules['bank']=array(
		'name'=>'Bank'
		,'id'=>'TBank'
		,'icon'=>'119-piggy-bank.png'
		,'moduleRequire'=>array('user')
	);

	$conf->menu->top[] = array(
		'name'=>"Bank"
		,'id'=>'TBank'
		,'position'=>3
		,'url'=>HTTP.'modules/bank/'
		,'module'=>'bank'
	);
	