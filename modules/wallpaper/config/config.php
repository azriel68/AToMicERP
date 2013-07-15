<?php

	$conf->modules['wallpaper']=array(
		'name'=>'Wallpaper'
		,'id'=>'TWallpaper'
		,'class'=>array()
	);

	
	$conf->menu->admin[] = array(
		'name'=>'__tr(ChangeWallpaper)__'
		,'id'=>'changeWallpaper'
		,'position'=>80
		,'url'=>'javascript:getWallpaper()'
		,'right'=>array('user','wallpaper','change')
	);
	