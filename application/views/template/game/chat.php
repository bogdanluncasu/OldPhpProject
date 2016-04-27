<div class='container' ng-cloak ng-app="chatApp">
    <h1>Awakening Chat</h1>
    <div class='chatbox' ng-controller="MessageCtrl as chatMessage">
        <div class='chatbox__user-list' id="users"></div>
        <div class="chatbox__messages" ng-repeat="message in messages" >
            <div id="chat">
            </div>
        </div>

        <form id="send_msg">
            <input size="60" id="msg" placeholder="Enter your message"/>
        </form>
    </div>
    <script src="http://localhost:8888/socket.io/socket.io.js"></script>
    <script>

        jQuery(function ($) {
            var socket = io.connect("http://localhost:8888/");
            var send_msg = $('#send_msg');
            var msg = $('#msg');
            var chat = $('#chat');
            var users = $('#users');
            var set_name = "<?php echo $_SESSION['username']; ?>";

            socket.emit('new_user', set_name, function (data) {
                       console.log("Amazing");
            });
            socket.on('usernames', function (data) {
                var html = '';
                for (i = 0; i < data.length; i++){



                    html += "<div class='chatbox__user--active'>"+ "<p>"+ data[i]+"</p>" + "</div>";
                }
                users.html(html);
            });
            send_msg.submit(function (e) {
                e.preventDefault();
                socket.emit('send_msg', msg.val());
                msg.val('');
            });
            socket.on('new_msg', function (data) {
                chat.append(
                "<div class='chatbox__messages__user-message--ind-message'>" +
                "<p class='message'>"+data+"</p> </div>"
                );
            });
           
        });
    </script>