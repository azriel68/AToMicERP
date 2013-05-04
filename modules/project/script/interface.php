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
		case 'task' :
			
			$task=new TTask;
			$task->load($db, $_REQUEST['id']);
			
			__out($task->get_values());

			break;
	}

}
function _put(&$db, $case) {
	switch ($case) {
		case 'task' :
			__out(_task($db, __get('id',0), $_REQUEST));
			break;
		case 'sort-task' :
			
			_sort_task($db, $_REQUEST['TTaskID']);
			
			break;
	}

}
function _sort_task(&$db, $TTask) {
	
	foreach($TTask as $rank=>$id) {
		$task=new TTask;
		$task->load($db, $id);
		$task->rank = $rank;
		$task->save($db);
	}
	
}
function _task(&$db, $id_task, $values) {
	$task=new TTask;
	if($id_task) $task->load($db, $id_task);
	$task->set_values($values);
	
	$task->save($db);
	
	if(empty($task->name)) {
		$task->name = __tr("Task").' '.$task->getId();
		$task->save($db);	
	}
	return $task->get_values();
}

function _tasks(&$db, $id_project, $type) {
	
	$TId = TRequeteCore::_get_id_by_sql($db, "SELECT id FROM ".DB_PREFIX."project_task WHERE id_project=".$id_project." AND type='".$type."' ORDER BY rank");
	$TTask = array();
	foreach($TId as $id) {
		$t=new TTask;
		$t->load($db, $id);
		
		$TTask[] = $t->get_values();
	}
	
	return $TTask;
}
