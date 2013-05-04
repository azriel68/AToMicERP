function project_get_task(id_project, liste, type) {
	
	$.ajax({
		url : "./script/interface.php"
		,data: {
			json:1
			,get : 'tasks'
			,type : type
			,id_project : id_project
		}
		,dataType: 'json'
	})
	.done(function (tasks) {
		
		$.each(tasks, function(i, task) {
			project_draw_task(task, $('#'+liste));
		});
		
		$('#'+liste).sortable();
		$('#'+liste).droppable();
	}); 
}
function project_create_task(id_project) {
	$.ajax({
		url : "./script/interface.php"
		,data: {
			json:1
			,put : 'task'
			,id_project : id_project
			,type:'idea'
		}
		,dataType: 'json'
	})
	.done(function (task) {
	
		project_draw_task(task, $('#list-task-idea'));
		
	}); 
	
}
function project_draw_task(task, ul) {
	$('#task-blank').clone().attr('id', 'task-'+task.id).prependTo(ul);
	project_refresh_task(task);
}
function project_refresh_task(task) {
	
	$item = $('#task-'+task.id);
	
	var link_title = $item.find('a.title');
	link_title.attr("href", 'javascript:project_develop_task('+task.id+');');
	link_title.html(task.name);
	
}
function project_save_task(id_task) {
	$.ajax({
		url : "./script/interface.php"
		,data: {
			json:1
			,put : 'task'
			,id : id_task
			,id_project : id_project
		}
		,dataType: 'json'
	})
	.done(function (task) {
	
		project_refresh_task(task);
	}); 
	
}

function project_change_task_status(id_task) {
	
}
