<?php


	$conf->modules['chat']=array(
		'name'=>'chat'
		,'id'=>'TChat'
		,'class'=>array('TChat')
		,'moduleRequire'=>array('core')
	);

	
	$conf->js[] =Tools::getUrl('chat/js/chat.js.php');
	$conf->js[] =Tools::getUrl('chat/js/jquery.chatjs.js');
	$conf->js[] =Tools::getUrl('chat/js/jquery.chatjs.longpollingadapter.js.php');
	$conf->js[] = Tools::getUrl('chat/js/jquery.autosize.min.js');
	
	$conf->css[] =Tools::getUrl('chat/css/jquery.chatjs.css');

	TAtomic::addExtraField('TUser','chat_last_connection', array('type'=>'date','index'=>true));
