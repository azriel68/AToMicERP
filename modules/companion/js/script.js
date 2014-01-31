function showCompanion(mood, message) {
	
	if($('#companion').length==0) {
		
		$('body').append('<div id="companion" style="display:none; width:115px; height:170px; position:absolute; bottom : 20px; right : 20px; background-image:url('+HTTP+'modules/companion/img/companion.jpg)"></div>');
		
		if(mood=='sad') {
			$('#companion').css('background-position','-590px -170px');
		}
		else if(mood=='happy') {
			$('#companion').css('background-position','-480px 0px');
		}
		
		$('#companion').slideToggle().delay(1000).slideToggle('slow');
		
	}
	
}
