function project_get_tasks(id_project, liste, status) {
	
	$.ajax({
		url : "./script/interface.php"
		,data: {
			json:1
			,get : 'tasks'
			,status : status
			,id_project : id_project
			,async:false
		}
		,dataType: 'json'
	})
	.done(function (tasks) {
		
		$.each(tasks, function(i, task) {
			project_draw_task(task, $('#'+liste));
		});
				
	}); 
}
function project_create_task(id_project) {
	$.ajax({
		url : "./script/interface.php"
		,data: {
			json:1
			,put : 'task'
			,id_project : id_project
			,status:'idea'
		}
		,dataType: 'json'
	})
	.done(function (task) {
	
		project_draw_task(task, $('#list-task-idea'));
		
	}); 
	
}
function project_draw_task(task, ul) {
	$('#task-blank').clone().attr('id', 'task-'+task.id).appendTo(ul);
	project_refresh_task(task);
}
function project_refresh_task(task) {
	
	$item = $('#task-'+task.id);
	
	
	$item.attr('task-id', task.id);
	
	$item.removeClass('idea todo inprogress finish');
	$item.addClass(task.status);
	
	$item.find('input[name=title]').val(task.name);
	$item.find('input[name=status]').val(task.status);
	$item.find('input[name=type]').val(task.type);
	
	var link_title = $item.find('a.title');
	link_title.attr("href", 'javascript:project_develop_task('+task.id+');');
	link_title.html(task.name);
	
}
function project_get_task(id_project, id_task) {
	var taskReturn="";
	$.ajax({
		url : "./script/interface.php"
		,data: {
			json:1
			,get : 'task'
			,id : id_task
			,id_project : id_project
		}
		,dataType: 'json'
		,async:false
	})
	.done(function (lTask) {
		//alert(lTask.name);
		taskReturn = lTask;
	}); 
	
	return taskReturn;
}
function project_init_change_type(id_project) {
	
    $('.task-list').sortable( {
    	connectWith: ".task-list"
    	, placeholder: "ui-state-highlight"
    	,receive: function( event, ui ) {
			task=project_get_task(id_project, ui.item.attr('task-id'));
			task.status = $(this).attr('rel');
			
			$('#task-'+task.id).css('top','');
	        $('#task-'+task.id).css('left','');	
			$('#list-task-'+task.status).prepend( $('#task-'+task.id) );	
			console.log('#task-'+task.id+' --> '+'#list-task-'+task.status);	
			
			project_save_task(id_project, task);
									        
	  }  
	  ,update:function(event,ui) {
	  	var sortedIDs = $( this ).sortable( "toArray" );
	  	
	  	var TTaskID=[];
	  	$.each(sortedIDs, function(i, id) {
	  		
	  		taskid = $('#'+id).attr('task-id');
	  		TTaskID.push( taskid );
	  	});
	  		
	  	$.ajax({
			url : "./script/interface.php"
			,data: {
				json:1
				,put : 'sort-task'
				,TTaskID : TTaskID
			}
			,dataType: 'json'
		});
	  	
	  }
    });

    
    
}
function project_save_task(id_project, task) {
	$.ajax({
		url : "./script/interface.php"
		,data: {
			json:1
			,put : 'task'
			,id : task.id
			,status : task.status
			,id_project : id_project
		}
		,dataType: 'json'
	})
	.done(function (task) {
		project_refresh_task(task);
	}); 
	
}
function project_develop_task(id_task) {
	$('#task-'+id_task+' div.view').toggle();
}
