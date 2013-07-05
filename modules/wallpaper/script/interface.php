<?php

require ('../../../inc.php');

$get = isset($_REQUEST['get']) ? $_REQUEST['get'] : '';
$put = isset($_REQUEST['put']) ? $_REQUEST['put'] : '';

$db=new TPDOdb;
_put($db, $put);
_get($db, $get);
$db->close();

function _get(&$db, $case) {
	switch ($case) {
		case 'wallpaper' :
			
			__out( json_decode( file_get_contents( "https://api.desktoppr.co/1/wallpapers/random" ) ) );

			break;
	}

}
function _put(&$db, $case) {
	switch ($case) {
		
	}

}

