<?php
	require('../../../inc.php');
?>
$(document).ready(function() {
	
	var cookie = $.cookie('atomicWallpaper');
	if (!cookie) {
		
		getWallpaper();
		
	}
	else {
		changeWallpaper(cookie);
	}
	
	
});

function getWallpaper() {
	oldContent = $('#menu-admin-changeWallpaper').html();
	$('#menu-admin-changeWallpaper').html("<?=__tr("Loading new wallpaper") ?>");
	
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
			$.cookie('atomicWallpaper', wallpaper.response.image.url, { expires: 360, path: "/" });
			changeWallpaper(wallpaper.response.image.url);
			
			$('#menu-admin-changeWallpaper').html(oldContent);
					
		}); 
	
}
function changeWallpaper(url) {
	$('body').css('background-image', 'url('+url+')');
}
