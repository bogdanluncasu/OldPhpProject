<body>
<div id="main_container">
    <nav id="main_menu">
        <input type="button" id="register_show" value="Register"/>
        <input type="button" id="login_show" value="Login"/>
    </nav>
    <div id="data_container">
        <div class="form_container">
            <form class="register_form">
                <p>Username</p> <input type="text"/>
                <p>Password</p> <input type="password"/>
                <p>Retype password</p> <input type="password"/>
                <p>E-mail</p> <input type="text"/>
                <p></p><input type="submit" value="Register" id="register"/>
            </form>
            <form class="login_form">
                <p>Username</p> <input type="text"/>
                <p>Password</p> <input type="password"/>
                <p></p><input type="submit" value="Login"/>

            </form>


        </div>
    </div>
</div>
<script>
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
    });
</script>
</body>