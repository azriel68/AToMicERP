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
		case 'tasks' :
			
			__out(_tasks($db, $_REQUEST['id_project'], $_REQUEST['type']));

			break;
	}

}
function _put(&$db, $case) {
	switch ($case) {
		case 'task' :
			print 'ok';

			break;
	}

}

function _tasks(&$db, $id_project, $type) {
	
	//return TRequeteCore::id_from...($db, $sql, 'id', 'name');
	
}
