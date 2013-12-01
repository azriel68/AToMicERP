$(document).ready(function() {
	
	/*
	 FAusse bonne idée ?
	 * */
	initInterface();
	
	
});

function initInterface() {
	$('div.tabs a').each(function() {
		
		var url = $(this).attr('href');
		if(url=='#') {
			return false;
		}
		
		$(this).attr('href','#'+url);
		
		$(this).click(function() {
			//$('div.content').html("Loading...");
			$('div.content').load(url+' div.content', function() {
				if(typeof InPageHook == 'function') {
					InPageHook();
				}
				
				initInterface();
			});
			
		});
		
	});
	
	$('a#button-action-edit').each(function() {
		
		var url = $(this).attr('href');
		if(url=='#') {
			return false;
		}

		$(this).attr('href','#');
		
		$(this).click(function() {
			//$('div.content').html("Loading...");
			
			$('div.content').load(url+' div.content', function( response, status, xhr ) {
				if(typeof InPageHook == 'function') {
					InPageHook();
				}
				initInterface();
			});
			
		});
		
	});
	
	$('a#button-action-cancel').each(function() {
		
		var url = $(this).attr('href');
		if(url=='#') {
			return false;
		}

		$(this).attr('href','#');
		
		$(this).click(function() {
			//$('div.content').html("Loading...");
			$('div.content').load(url+' div.content', function() {
				if(typeof InPageHook == 'function') {
					InPageHook();
				}

				initInterface();
			});
		});
		
	});
}


function errorMsg(message) {
	
		jError(
			message,
			{
			  autoHide : true, // added in v2.0
			  clickOverlay : true, // added in v2.0
			  MinWidth : 250,
			  TimeShown : 3000,
			  ShowTimeEffect : 200,
			  HideTimeEffect : 200,
			  LongTrip :20,
			  HorizontalPosition : 'center',
			  VerticalPosition : 'top',
			  ShowOverlay : true,
	   		  ColorOverlay : '#000',
			  OpacityOverlay : 0.3,
			  onClosed : function(){ // added in v2.0
			   
			  },
			  onCompleted : function(){ // added in v2.0
			   
			  }
		});
}
function importantMsg(message) {
	jSuccess(
			message,
			{
			  autoHide : true, // added in v2.0
			  MinWidth : 250,
			  TimeShown : 2000,
			  ShowTimeEffect : 200,
			  HideTimeEffect : 200,
			  LongTrip :20,
			  HorizontalPosition : 'center',
			  VerticalPosition : 'top',
			  ShowOverlay : true,
	   		  ColorOverlay : '#000',
			  onClosed : function(){ // added in v2.0
			   
			  },
			  onCompleted : function(){ // added in v2.0
			   
			  }
	});
}
function infoMsg(message) {
	jSuccess(
			message,
			{
			  autoHide : true, // added in v2.0
			  MinWidth : 250,
			  TimeShown : 2000,
			  ShowTimeEffect : 200,
			  HideTimeEffect : 200,
			  LongTrip :20,
			  HorizontalPosition : 'right',
			  VerticalPosition : 'top',
			  ShowOverlay : false,
	   		  ColorOverlay : '#000',
			  onClosed : function(){ // added in v2.0
			   
			  },
			  onCompleted : function(){ // added in v2.0
			   
			  }
	});
	
	
}
