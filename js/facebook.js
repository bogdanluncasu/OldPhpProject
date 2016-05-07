// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response,type) {
    if(type!=0) {
        console.log('statusChangeCallback');
        console.log(response);
        // The response object is returned with a status field that lets the
        // app know the current login status of the person.
        // Full docs on the response object can be found in the documentation
        // for FB.getLoginStatus().
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
window.fbAsyncInit = function () {
    FB.init({
        appId: '1717580785194614',
        cookie: true,  // enable cookies to allow the server to access
                       // the session
        xfbml: true,  // parse social plugins on this page
        version: 'v2.6' // use graph api version 2.5
    });

    FB.getLoginStatus(function (response) {
        statusChangeCallback(response,0);
    });

};
function login(){
        console.log("dsad");
        FB.login(function (response) {
                statusChangeCallback(response,1);
        }, {scope: 'public_profile,email,user_friends'});
};

// Load the SDK asynchronously
(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));



