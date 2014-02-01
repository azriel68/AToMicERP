function showCompanion(mood, message) {
	
	if($('#companion').length==0) {
		
		$('body').append('<div id="companion" style="display:none; width:115px; height:170px; position:absolute; bottom : 20px; right : 20px; background-image:url('+HTTP+'modules/companion/img/companion.jpg)"><div class="bubble" style="display:none;position:relative; left:-100px; top: -100px; background: #fff; border:2px solid #333; border-radius : 10px; padding:10px; width: 150px; height:100px; overflow:hidden;"></div></div>');
		
		if(mood=='sad') {
			$('#companion').css('background-position','-590px -170px');
		}
		else if(mood=='happy') {
			$('#companion').css('background-position','-480px 0px');
		}

		$('#companion div.bubble').html(message);

		if(mood=='tip') d = 5000;
		else d=2000;
		
		$('#companion').slideToggle(function() {
			if(message!=''){ $('#companion div.bubble').fadeIn().delay(d-1000).fadeOut(); }
		}).delay(d).slideToggle('slow');
		
	}
	
}
