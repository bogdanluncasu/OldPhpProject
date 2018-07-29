function statusChangeCallback(response,type) {
    if(type!=0) {
        if (response.status === 'connected') {
            FB.api('/me', function (response) {
                $.post("site/loginFb", {
                    fbname: response.name,
                    fbId: response.id
                }, function (data) {
                    $(location).attr("href", "game");
                });
            });
        }
    }
}

function logout() {
    FB.logout(function (response) {
        $(location).attr("href", "game/logout");
    });
}

function getFriends(){
    FB.api(
        "/me/friends",
        function (response) {
            if (response && !response.error) {
                var friends=$("#friendList");
                $.each(response['data'],function(index,element){
                    FB.api(
                      "/"+element['id']+"/picture?redirect=false",
                        function(data){
                            friends.append("<div class='friend'>" +
                                "<img src=\""+data['data']['url']+"\" title='"+element['name']+"'/></div>");
                        }
                    );
                })
            }
        }
    );
};

var verify=setInterval(function(){
    if (typeof(FB) != 'undefined'
        && FB != null ) {
        getFriends();
        clearInterval(verify);
    } }, 3000);

window.fbAsyncInit = function () {
    FB.init({
        appId: '1717580785194614',
        cookie: true,  // enable cookies to allow the server to access
                       // the session
        xfbml: true,  // parse social plugins on this page
        version: 'v3.1' // use graph api version 3.1
    });

    FB.getLoginStatus(function (response) {
        statusChangeCallback(response,0);
    });


};
(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));



function login(){
        FB.login(function (response) {
                statusChangeCallback(response,1);
        }, {scope: 'public_profile,email,user_friends'});
};


