/**
 * ChatJS 1.0 - MIT License
 * www.chatjs.net
 * 
 * Copyright (c) 2013, André Pena
 * All rights reserved.
 *
 **/

// More about adapters: https://github.com/andrerpena/chatjs/wiki/The-anatomy-of-a-ChatJS-adapter
// About the long polling adapter: https://github.com/andrerpena/chatjs/wiki/Getting-up-and-running-with-long-polling

(function ($) {

    // adds a long-polling listener
    $.addLongPollingListener = function (providerName, success, error) {
        /// <summary>Adds a listener to the long polling</summary>
        /// <param name="providerName" type="String">Provider FullName</param>
        /// <param FullName="success" type="Function">Handler that will be called when there are new events</param>
        /// <param FullName="error" type="Function"> Handler that will be called when an error ocurred processing the request. (optional)</param>
        if (!$._longPollingData)
            $._longPollingData = {
                listeners: new Object(),
                started: false,
                lastFetchTimeStamp: 0
            };
        if ($._longPollingData.listeners[providerName])
            throw "Cannot add long polling listener. There's already a listener for the provider FullName. Provider FullName: " + providerName;
        $._longPollingData.listeners[providerName] = new Object();
        $._longPollingData.listeners[providerName].success = success;
        $._longPollingData.listeners[providerName].error = error;
    };

    // starts the long polling process
    $.startLongPolling = function (longPollingUrl) {
        /// <summary>Starts the long polling</summary>
        /// <param FullName="longPollingUrl" type="String">The long polling Url</param>
        if (!$._longPollingData)
            throw "Cannot start long polling. There's no registered listeners";
        if ($._longPollingData.started)
            throw "Cannot start long polling. It has already started";

        $._longPollingData.started = true;

        function doLongPollingRequest() {
            $.ajax({
                url: longPollingUrl,
                cache: false,
                data: {
                    timestamp: $._longPollingData.lastFetchTimeStamp
                },
                success: function (data, s) {
                    $._longPollingData.lastFetchTimeStamp = data.Timestamp;
                    for (var i = 0; i < data.Events.length; i++) {
                        var event = data.Events[i];
                        if (!$._longPollingData.listeners[event.ProviderName])
                            throw "Long polling server sent a message but there is no client listener. Provider FullName: " + event.ProviderName;
                        else {
                            var listener = $._longPollingData.listeners[event.ProviderName].success;
                            try {
                                listener(event);
                            } catch (ex) {
                                throw "Long polling listener triggered an Exception: " + ex;
                            }
                        }
                    };

                    setTimeout(function () {
                        doLongPollingRequest();
                    }, 1000);
                },
                error: function (data) {
                    for (var providerName in $._longPollingData.listeners) {
                        if ($._longPollingData.listeners[providerName].error)
                            $._longPollingData.listeners[providerName].error.apply(this, arguments);
                    };

                    // an error ocurred but life must go on
                    setTimeout(function () {
                        doLongPollingRequest();
                    }, 1000);

                    if (console && console.log) {
                        console.log("error in the long-polling");
                        console.log(data);
                    }
                }
            });
        }

        doLongPollingRequest();
    };

})(jQuery);

// actual ChatJS long polling adapter
function LongPollingAdapter(options) {
    /// <summary>
    /// Long polling adapter for ChatJS. In order to use this adapter.. Pass an instance of this 
    /// function to $.chat()
    /// </summary>

    this.defaults = {
        sendMessageUrl: '/chat/sendmessage',
        sendTypingSignalUrl: '/chat/sendtypingsignal',
        getMessageHistoryUrl: '/chat/getmessagehistory',
        userInfoUrl: '/chat/getuserinfo',
        usersListUrl: '/chat/getuserslist'
    };

    //Extending options:
    this.opts = $.extend({}, this.defaults, options);
}

LongPollingAdapter.prototype = {
    init: function (chat, done) {
        /// <summary>This function will be called by ChatJs to initialize the adapter</summary>
        /// <param FullName="chat" type="Object"></param>
        var _this = this;

        $.addLongPollingListener("chat",
                // success
                function (event) {
                    if (event.EventKey == "new-messages")
                        for (var i = 0; i < event.Data.length; i++)
                            chat.client.sendMessage(event.Data[i]);
                    else if (event.EventKey == "user-list")
                        chat.client.usersListChanged(event.Data);
                    else if (event.EventKey == "user-typed")
                        chat.client.sendTypingSignal(event.Data);
                },
                // error
                function (e) {
                    switch (e.status) {
                        case 403:
                            chat.client.showError("Your user is not logged in or not allowed to access the chat now");
                            break;
                        case 500:
                            chat.client.showError("An error ocurred while trying to load the chat");
                            break;
                        default:
                            // chances are that the user just clicked a link. When you click a link
                            // the pending ajaxes break
                    }
                }
            );

        // These are the methods that ARE CALLED BY THE CLIENT
        // Client functions should call these functions
        _this.server = {
            sendMessage: function (otherUserId, messageText, clientGuid, done) {
                /// <summary>Sends a message to server</summary>
                /// <param FullName="otherUserId" type="Number">The id of the user to which the message is being sent</param>
                /// <param FullName="messageText" type="String">Message text</param>
                /// <param FullName="clientGuid" type="String">Message client guid. Each message must have a client id in order for it to be recognized when it comes back from the server</param>
                /// <param FullName="done" type="Function">Function to be called when this method completes</param>
                $.ajax({
                    type: "POST",
                    url: _this.opts.sendMessageUrl,
                    data: {
                        otherUserId: otherUserId,
                        message: messageText,
                        clientGuid: clientGuid
                    },
                    cache: false,
                    success: function (result) {
                        // fine
                        if (done)
                            done(result);
                    },
                    error: function (result) {
                        // too bad
                    }
                });
            },
            sendTypingSignal: function (otherUserId, done) {
                /// <summary>Sends a typing signal to the server</summary>
                /// <param FullName="otherUserId" type="Number">The id of the user to which the typing signal is being sent</param>
                /// <param FullName="done" type="Function">Function to be called when this method completes</param>
            
                $.ajax({
                    type: "POST",
                    async: false,
                    url: _this.opts.sendTypingSignalUrl,
                    data: {
                        otherUserId: otherUserId
                    },
                    cache: false,
                    success: function (data) {
                        // fine
                        if (done)
                            done(data.Messages);
                    },
                    error: function () {
                        // too bad
                    }
                });
            },
            getMessageHistory: function (otherUserId, done) {
                /// <summary>Gets message history from the server</summary>
                /// <param FullName="otherUserId" type="Number">The id of the user from which you want the history</param>
                /// <param FullName="done" type="Number">Function to be called when this method completes</param>
                $.ajax({
                    type: "GET",
                    async: false,
                    url: _this.opts.getMessageHistoryUrl,
                    data: {
                        otherUserId: otherUserId
                    },
                    cache: false,
                    success: function (data) {
                        // fine
                        if (done)
                            done(data.Messages);
                    },
                    error: function () {
                        // too bad
                    }
                });
            },
            getUserInfo: function (userId, done) {
                /// <summary>Gets information about the user</summary>
                /// <param FullName="userId" type="Number">The id of the user from which you want the information</param>
                /// <param FullName="done" type="Function">FUnction to be called when this method completes</param>
                $.ajax({
                    type: "GET",
                    async: false,
                    url: _this.opts.userInfoUrl,
                    data: {
                        userId: userId
                    },
                    cache: false,
                    success: function (result) {
                        // fine
                        if (done)
                            done(result.User);
                    },
                    error: function () {
                        // too bad
                    }
                });
            },
            getUsersList: function (done) {
                /// <summary>Gets the list of the users in the current room</summary>
                $.ajax({
                    type: "GET",
                    async: false,
                    url: _this.opts.usersListUrl,
                    cache: false,
                    success: function (result) {
                        // fine
                        if (done)
                            done(result.Users);
                    },
                    error: function () {
                        // too bad
                    }
                });
            }
        };

        // starts to poll the server for events
        $.startLongPolling('/longpolling/getevents');

        // function passed by ChatJS to the adapter to be called when the adapter initialization is completed
        done();
    }
}
