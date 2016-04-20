
function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    if (response.status === 'connected') {
        FB.api('/me', function (response) {
            $.post("site/loginFb", {
                fbname: response.name,
                fbId: response.id
            }, function (data) {
                $(location).attr("href", "game");
            });
        });

    } else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        document.getElementById('status').innerHTML = 'Please log ' +
            'into this app.';
    } else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        document.getElementById('status').innerHTML = 'Please log ' +
            'into Facebook.';
    }
}

function logout() {
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            FB.logout(function(response) {
                $.post("game/logoutFacebook",{},function($data){
                    $(location).attr("href", "game/logout");
                })
            });
        }
    });
}
window.fbAsyncInit = function () {
    FB.init({
        appId: '1717580785194614',
        cookie: true,  // enable cookies to allow the server to access
                       // the session
        xfbml: true,  // parse social plugins on this page
        version: 'v2.6' // use graph api version 2.5
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



