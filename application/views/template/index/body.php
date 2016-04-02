<body>
<div id="main_container">
    <nav id="main_menu">
        <input type="button" id="register_show" class="show" value="Register"/>
        <input type="button" id="login_show" class="show" value="Login"/>
    </nav>
    <div id="data_container">
        <div class="form_container">
            <form class="register_form">
                <p>Username</p> <input type="text" id="username" name="username"/>
                <p>Password</p> <input type="password" id="password" name="password"/>
                <p>Retype password</p> <input type="password" id="con_password" name="con_password"/>
                <p>E-mail</p> <input type="text" id="email" name="email"/>
                <p id="error"></p><input type="button" value="Register" id="register"/>
            </form>
            <form class="login_form">
                <p>Username</p> <input type="text" id="login_username"/>
                <p>Password</p> <input type="password" id="login_password"/>
                <p id="login_error"></p><input type="button" id="login" value="Login"/>
            </form>
        </div>
        <div id="rules">
            <?php ?>
        </div>
    </div>
</div>

