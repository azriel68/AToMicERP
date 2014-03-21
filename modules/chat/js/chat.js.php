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
		    	sendMessageUrl: '<?php echo Tools::getUrl('chat/script/interface.php?put=send-message') ?>'
       			,sendTypingSignalUrl: '<?php echo Tools::getUrl('chat/script/interface.php?get=ping') ?>'
        		,getMessageHistoryUrl: '<?php echo Tools::getUrl('chat/script/interface.php?get=message-history') ?>'
        		,userInfoUrl: '<?php echo Tools::getUrl('chat/script/interface.php?get=user-info') ?>'
        		,usersListUrl: '<?php echo Tools::getUrl('chat/script/interface.php?get=users-list') ?>'
		    	
		    })
		});
	
		$.addLongPollingListener("chat",
		    // success
		    function (event) {
		        if (event.EventKey == "new-messages") {
		            for (i in event.Data) {
		            	chat.client.sendMessage(event.Data[i]);
		            }
		        	
		        }
		        else if (event.EventKey == "user-list") {
		            chat.client.usersListChanged(event.Data);
			        // other checks
		        	
		        }
		    }
		    ,function (e) {
		        // error handling here
		    }
		);
		$.startLongPolling('<?php echo Tools::getUrl('chat/script/interface.php') ?>');
		
});

