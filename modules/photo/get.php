<?php

	require('../../inc.php');

	if(!$user->isLogged()) {
		print 0;
	}
	else {
		
		
		$photo=new TPhoto;
		$db=new TPDOdb;
		
		$photo->load($db, (int)$_REQUEST['id']);
		
		$w = __get('w', 0);
		$h = __get('h', 0);
		
		$rotate = __get('rotate',0);
		
		
		$photo->image($w, $h, $rotate);
		
	}
