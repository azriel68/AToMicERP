<?php

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$product=new TProduct;
$db=new TPDOdb;

$db->close();