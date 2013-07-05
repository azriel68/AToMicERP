<?php
	require('../../../inc.php');
?>
$(document).ready(function() {
	
	$('#menu-admin-changeWallpaper').append('<input type="checkbox" id="changeWallpaperEveryDay" value="1" /> ');
	
	var changeWallpaperEveryDay = $.cookie('atomicChangeWallpaperEveryDay');
	var myWallpaper = $.cookie('atomicWallpaper');
	
	if(changeWallpaperEveryDay!=null && changeWallpaperEveryDay==1) {
		$('#changeWallpaperEveryDay').attr("checked","checked");	
	}
	else {
		changeWallpaperEveryDay=0;
	}
	
	$('#changeWallpaperEveryDay').change(function() {
		
		if($(this).is(':checked')) {
			infoMsg("<?=__tr('Loading new wallpaper every day activated') ?>");
			$.cookie('atomicChangeWallpaperEveryDay', 1, { expires: 360, path: "/" });
			$.cookie('atomicWallpaper', myWallpaper, { expires: 1, path: "/" });
		}
		else {
			infoMsg("<?=__tr('Feature desactivated') ?>");
			$.cookie('atomicChangeWallpaperEveryDay', 0, { expires: 360, path: "/" });
			$.cookie('atomicWallpaper', myWallpaper, { expires: 360, path: "/" });
		}
		
	});
	
	
	
	if (!myWallpaper) {
		
		getWallpaper(changeWallpaperEveryDay);
		
	}
	else {
		changeWallpaper(myWallpaper);
	}
	
	
	
	
});

function getWallpaper(changeWallpaperEveryDay) {
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
			var expirationDay = (changeWallpaperEveryDay==1) ? 1 : 360;
			
			$.cookie('atomicWallpaper', wallpaper.response.image.url, { expires: expirationDay, path: "/" });
			changeWallpaper(wallpaper.response.image.url);
			
			$('#menu-admin-changeWallpaper').html(oldContent);
					
		}); 
	
}
function changeWallpaper(url) {
	$('body').css('background-image', 'url('+url+')');
}
