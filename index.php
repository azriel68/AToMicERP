<?php

	require('inc.php');

	$db=new TPDOdb;

	$user = TAtomic::getUser($db);

	if($user->isLogged()) {
		header('location:home.php');		
	}
	else {
		login();
	}
