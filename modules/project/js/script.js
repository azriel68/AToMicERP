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
			project_draw_task(id_project, task, $('#'+liste));
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
	
		project_draw_task(id_project, task, $('#list-task-idea'));
		project_develop_task(task.id);
	}); 
	
}
function project_draw_task(id_project, task, ul) {
	$('#task-blank').clone().attr('id', 'task-'+task.id).appendTo(ul);
	project_refresh_task(id_project, task);
}
function project_refresh_task(id_project, task) {
	
	$item = $('#task-'+task.id);
	
	
	$item.attr('task-id', task.id);
	
	$item.removeClass('idea todo inprogress finish');
	$item.addClass(task.status);
	
	$item.find('[rel=name]').attr('id','task-name-'+task.id).val(task.name);
	$item.find('[rel=status]').attr('id','task-status-'+task.id).val(task.status);
	$item.find('[rel=type]').attr('id','task-type-'+task.id).val(task.type);
	$item.find('[rel=point]').attr('id','task-point-'+task.id).val(task.point);
	$item.find('[rel=description]').attr('id','task-description-'+task.id).val(task.description);
	
	$item.find('a.title').attr("href", 'javascript:project_develop_task('+task.id+');').html(task.name);
	$item.find('a.save').attr("href", 'javascript:project_getsave_task('+id_project+','+task.id+');project_develop_task('+task.id+');');
	
	
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
function project_getsave_task(id_project, id_task) {
	
	task = project_get_task(id_project, id_task);
	$item = $('#task-'+task.id);
	
	task.name = $item.find('[rel=name]').val();
	task.status = $item.find('[rel=status]').val();
	task.type = $item.find('[rel=type]').val();
	task.point = $item.find('[rel=point]').val();
	task.description = $item.find('[rel=description]').val();
	
	project_save_task(id_project, task);
}
function project_save_task(id_project, task) {
	$('#task-'+task.id).css({ opacity:.5 });
	
	$.ajax({
		url : "./script/interface.php"
		,data: {
			json:1
			,put : 'task'
			,id : task.id
			,status : task.status
			,id_project : id_project
			,type : task.type
			,description: task.description
			,point : task.point
			,name : task.name
		}
		,dataType: 'json'
		,type:'POST'
	})
	.done(function (task) {
		project_refresh_task(id_project, task);
		$('#task-'+task.id).css({ opacity:1 });
	}); 
	
}
function project_develop_task(id_task) {
	$('#task-'+id_task+' div.view').toggle();
}
