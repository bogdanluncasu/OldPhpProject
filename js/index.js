/**
 * Created by bogdan on 4/2/16.
 */
$(document).ready(function () {
    $("#register_show").click(
        function () {
            $(".form_container").show();
            $(".login_form").hide();
            $(".register_form").show();
        }
    );
    $("#login_show").click(
        function () {
            $(".form_container").show();
            $(".register_form").hide();
            $(".login_form").show();
        }
    );
    $("#register").click(
        function () {
            var username = $("#username").val();
            var password = $("#password").val();
            var con_password = $("#con_password").val();
            var email = $("#email").val();
            var error = $("#error");
            error.html("");
            if (username.length < 6)
                error.append("Username should be at least 6 characters<br/>");
            else if (password.length < 6)
                error.append("Password should be at least 6 characters<br/>");
            else if (email == '')
                error.append("Fill Email<br/>");
            else if (password != con_password)
                error.append("Your passwords don't match. Try again.<br/>");
            else $.post("site/register", {
                    username: username,
                    email: email,
                    password: password
                }, function (data) {
                    if (data == '1') {
                        error.html("Succesfully registered");
                    } else if (data == '2') {
                        error.html("Invalid email");
                    } else if (data == '3') {
                        error.html("Username exists");
                    }
                });
        });
    $("#login").click(function () {
        var username = $("#login_username").val();
        var password = $("#login_password").val();
        var error = $("#login_error");
        error.html("");
        if (username.length < 6)
            error.append("Username should be at least 6 characters<br/>");
        else if (password.length < 6)
            error.append("Password should be at least 6 characters<br/>");
        else $.post("site/login", {
                username: username,
                password: password
            }, function (data) {
                if (data == '1') {
                    error.html("Succesfully logged");
                    $(location).attr("href", "game");
                } else if (data == '2') {
                    error.html("Wrong password");
                } else if (data == '3') {
                    error.html("Username does not exists");
                }
            });
    });
});