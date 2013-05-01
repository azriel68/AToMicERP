$(document).ready(function() {
	$('a.right_status').click(function() {
		$.ajax({
			url : './script/interface.php'
			,data: {
				json : 1
				,put : 'right'
				,id_group : $('input[name="id_group"]').val()
				,module : $(this).attr('data-module')
				,submodule : $(this).attr('data-submodule')
				,action : $(this).attr('data-action')
			}
		})
		.done(function (res) {
			if(res == 'added') $(this).html('on');
			else if(res == 'removed') $(this).html('off');
			else alert(res);
		}); 
	});
});

function fillSelectEntity(login) {
	
	$.ajax({
		url : './modules/user/script/interface.php'
		,data: {
			json : 1
			,get : 'validEntities'
			,login : login
		}
		,dataType:'json'
		
	}).done(function(data) {
		$.each(data, function(index, row) {
			
		});
	});
}
