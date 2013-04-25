function project_get_task(id_project, liste, type) {
	
	$.ajax({
		url : HTTP_PROJECT_INTERFACE
		,data: {
			json:1
			,get : 'tasks'
			,type : type
			,id_project : id_project
		}
	})
	.done(function (tasks) {
		liste.sortable();
	}); 
}

function project_change_task_status(id_task) {
	
}
