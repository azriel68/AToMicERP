$(document).ready(function() {
	
	$.ajax({
        url: './script/interface.php',
        dataType: "json",
        crossDomain: true,
        async: false,
        data: {
        	get : "gel_all_user_rights",
        	json: 1,
        	planning : $('#id_planning').val()
     	}
    }).then(function(TPlanning_right){
    	$.each(TPlanning_right,function(user,TRight){
	    	if(TRight.admin == 1){
	    		$('#admintags').append('<li>'+user+'</li>');
	    	}
	    	else if(TRight.writer == 1){
	    		$('#modtags').append('<li>'+user+'</li>');
	    	}	
	    	else if(TRight.reader == 1){
	    		$('#lectags').append('<li>'+user+'</li>');
			}
	    });
    });
	
	$.ajax({
        url: './script/interface.php',
        dataType: "json",
        crossDomain: true,
        //async: false,
        data: {
        	get : "all_users",
        	json: 1
        }
    }).then(function(data){
    	var TLogin = new Array();
    	var TId = new Array();
    	
    	for(i=0;i< data.length; i++){
    		temp = data[i];
    		temp = temp.split(".");
    		TLogin.push(temp[1]);
    		TId[temp[1]] = temp[0];
    	}
    	
    	_create_tagit(TLogin,TId);
    });
    
    function _create_tagit(TLogin,TId){
    	$("#admintags").tagit({
    		autocomplete:{source : TLogin},
    		beforeTagAdded : function (event,ui){
    			/*if($('input[type=hidden][value='+ui.tagLabel+']'))
    				alert("TagAlreadyUsed");*/
    		},
			afterTagAdded : function (event,ui){
				_add_user_right(event,ui,TId[ui.tagLabel],"admin");
			},
			beforeTagRemoved : function (event,ui){
				_del_user_right($('#admintags input[name=tags][value='+ui.tagLabel+']').attr('id_right'));
			}
   		});
   		
   		$("#modtags").tagit({
    		autocomplete:{source : TLogin},
    		beforeTagAdded : function (event,ui){
    			/*if($('input[type=hidden][value='+ui.tagLabel+']'))
    				alert("TagAlreadyUsed");*/
       		},
			afterTagAdded : function (event,ui){
				_add_user_right(event,ui,TId[ui.tagLabel],"modifieur");
			},
			beforeTagRemoved : function (event,ui){
				_del_user_right($('#modtags input[name=tags][value='+ui.tagLabel+']').attr('id_right'));
			}
    	});
    	
    	$("#lectags").tagit({
    		autocomplete:{source : TLogin},
    		beforeTagAdded : function (event,ui){
    			/*if($('input[type=hidden][value='+ui.tagLabel+']'))
    				alert("TagAlreadyUsed");*/
    		},
			afterTagAdded : function (event,ui){
				_add_user_right(event,ui,TId[ui.tagLabel],"lecteur");
			},
			beforeTagRemoved : function (event,ui){
				_del_user_right($('#lectags input[name=tags][value='+ui.tagLabel+']').attr('id_right'));
			}
    	});
    }
    
   
   	function _add_user_right(event,ui,id_tag,type){
   		$.ajax({
	        url: './script/interface.php',
	        dataType: "json",
	        crossDomain: true,
	        data: {
	        	put : "add_user_right",
	        	json: 1,
	        	tag: id_tag,
	        	type:type,
	        	planning:$('#id_planning').val()
	        }
	    }).then(function (data){
	    	$('#'+data.type+' input[name=tags][value='+ui.tagLabel+']').attr('id_right',data.id_right);
	    });
   	}
   	
   	function _del_user_right(id_right){
   		$.ajax({
	        url: './script/interface.php',
	        dataType: "json",
	        crossDomain: true,
	        data: {
	        	put : "del_user_right",
	        	json: 1,
	        	right: id_right
	        }
	    });
   	}
});