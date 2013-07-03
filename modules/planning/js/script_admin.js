$(document).ready(function() {
	
	$.ajax({
        url: 'ajax.planning.php',
        dataType: "json",
        crossDomain: true,
        data: {
        	get : "all_users",
        	json: 1
        }
    }).then(function(data){
    	$("#admintags").tagit({
    		autocomplete:{source : data},
			afterTagAdded : function (event,ui){
				_add_user_right(event,ui,"admin");
			}
   		});
   		
   		$("#modtags").tagit({
    		autocomplete:{source : data},
			afterTagAdded : function (event,ui){
				_add_user_right(event,ui,"modifieur");
			}
    	});
    	
    	$("#lectags").tagit({
    		autocomplete:{source : data},
			afterTagAdded : function (event,ui){
				_add_user_right(event,ui,"lecteur");
			}
    	});
    });
    
   
   	function _add_user_right(event,ui,type){
   		$.ajax({
	        url: 'ajax.planning.php',
	        dataType: "json",
	        crossDomain: true,
	        data: {
	        	put : "add_user_right",
	        	json: 1,
	        	tag: ui.tagLabel,
	        	type:type,
	        	planning:$('#id_planning').val()
	        }
	    });
   	}
});