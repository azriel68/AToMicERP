<?php


	$conf->menu->top[] = array(
		'name'=>"Tier"
		,'id'=>'tier'
		,'position'=>1
		,'url'=>HTTP.'modules/tier/index.php'
	);

	
	$conf->modules[]=array(
		'name'=>'Société'
		,'id'=>'tier'
	);

	@$conf->template->tier->fiche = './template/tier.html';
	