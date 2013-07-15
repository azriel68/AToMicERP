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
			
			__out( array('url'=> _get_wallpaper()) );

			break;
	}

}
function _put(&$db, $case) {
	switch ($case) {
		
	}

}

function _get_wallpaper() {
global $user;

	$wallpaper = json_decode( file_get_contents( "https://api.desktoppr.co/1/wallpapers/random" ) );
	
	$url = $wallpaper->response->image->url;
	
	$dir = DOCROOT.'user/'.$user->id.'/wallpaper/';
	@mkdir($dir, 0777, true);
	
	/*
	 * Ajout lecture et suppresion des anciens fond
	 */
	
	$newW = 'user/'.$user->id.'/wallpaper/'.md5($url).substr($url,-4);
	
	copy($url, DOCROOT.$newW );
	
	return HTTP.'documents/'.$newW;
}
