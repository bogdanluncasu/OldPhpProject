<body>
<?php if (isset($_SESSION['username'])){
    if ($_SESSION['first'] != 0) {
        ?>
        <div id="main_container">
            <nav id="main_menu">
                <p>Welcome <span style="color:beige"><?php echo $_SESSION['username']; ?> </span>| <input type="button"
                                                                                                          id="logout"
                                                                                                          class="show"
                                                                                                          value="Logout"/>
                </p>
            </nav>
            <div id="data_container">
                <div id="rules">
                    <?php ?>
                </div>
            </div>
        </div>
    <?php } else { ?>

        <div id="main_container">
            <nav id="main_menu">
                <p>Welcome <span style="color:beige"><?php echo $_SESSION['username']; ?> </span>| <input type="button"
                                                                                                          id="logout"
                                                                                                          class="show"
                                                                                                          value="Logout"/>
                </p>
            </nav>
            <div id="data_container">
                <div class="centered"><p>Please choose your Hero</p></div>
                <div id="choose">
                    <input type="radio" name="choose" id="barbar" checked="true"/>
                    <label for="barbar"><img class="pict" src="resources/1.png" alt="I will hunt you down"/></label>
                    <input type="radio" name="choose" id="smart"/>
                    <label for="smart"><img class="pict" src="resources/2.png" alt=""/></label>
                    <input type="radio" name="choose" id="mage"/>
                    <label for="mage"><img class="pict" src="resources/3.png"
                                           alt="My magic will tear you apart"/></label>
                </div>
                <input type="button" class="show" value="Let's Fight" id="fight"/>
            </div>
        </div>

    <?php }
}else{ ?>
<div id="main_container">
    <div id="data_container">
        <p>You are not logged in</p>
    </div>
</div>
<?php } ?>