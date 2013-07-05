<?php
	require('../../../inc.php');
?>
$(document).ready(function() {
	$('body').css('background-image', '');
	
	var cookie = $.cookie('atomicWallpaper');
	if (!cookie) {
		
		$.ajax({
			url : "<?=HTTP ?>modules/wallpaper/script/interface.php"
			,data: {
				json:1
				,get : 'wallpaper'
				,async:true
			}
			,dataType: 'json'
		})
		.done(function (wallpaper) {
			$.cookie('atomicWallpaper', wallpaper.response.image.url, { expires: 1, path: "/" });
			changeWallpaper(wallpaper.response.image.url);
					
		}); 
		
	}
	else {
		changeWallpaper(cookie);
	}
	
	
});

function changeWallpaper(url) {
	$('body').css('background-image', 'url('+url+')');
}
