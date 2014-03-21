<?php

require ('../../../inc.php');

if(__get('id_user',0,'int')!=$user->id) {
	exit; // user usurpation or logout
}


$get =  __get('get', '');
$put = __get('put', '');

_put($db, $put);
_get($db, $get);


function _get(&$db, $case) {
	switch ($case) {
		case '???' :
			
			
			break;
	}

}
function _put(&$db, $case) {
	switch ($case) {
		
			
			
	}

}
