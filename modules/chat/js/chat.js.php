<?php
	require ('../../../inc.php');
?>

	$(document).ready(function() {
		
		$.chat({
		    user: {
		        Id: <?php echo $user->id ?>,
		        Name: '<?php echo addslashes($user->name()) ?>',
		        ProfilePictureUrl: '<?php echo $user->gravatar(100, true) ?>'
		    },
		    typingText: ' <?php echo __tr('is typing...') ?>',
		   
		    titleText: '<?php echo __tr('Chat') ?>',
		   
		    emptyRoomText: "<?php echo __tr('There\'s no one around here.') ?>",
		   
		    adapter: new LongPollingAdapter({
		    	sendMessageUrl: '<?php echo Tools::getUrl('chat/script/interface.php?put=send-message&json=1&id_user='.$user->id) ?>'
       			,sendTypingSignalUrl: '<?php echo Tools::getUrl('chat/script/interface.php?put=ping&json=1&id_user='.$user->id) ?>'
        		,getMessageHistoryUrl: '<?php echo Tools::getUrl('chat/script/interface.php?get=message-history&json=1&id_user='.$user->id) ?>'
        		,userInfoUrl: '<?php echo Tools::getUrl('chat/script/interface.php?get=user-info&json=1&id_user='.$user->id) ?>'
        		,usersListUrl: '<?php echo Tools::getUrl('chat/script/interface.php?get=users-list&json=1&id_user='.$user->id) ?>'
		    	
		    })
		});
	
		$.startLongPolling('<?php echo Tools::getUrl('chat/script/interface.php?id_user='.$user->id.'&put=start-polling&json=1') ?>');
		
});

