<?php


	$conf->modules['chat']=array(
		'name'=>'chat'
		,'id'=>'TChat'
		,'class'=>array()
		,'moduleRequire'=>array('core')
	);

	
	$conf->js[] =Tools::getUrl('chat/js/chat.js.php');
	$conf->js[] =Tools::getUrl('chat/js/jquery.chatjs.js');
	$conf->js[] =Tools::getUrl('chat/js/jquery.chatjs.longpollingadapter.js');
	
	$conf->css[] =Tools::getUrl('chat/css/jquery.chatjs.css');
