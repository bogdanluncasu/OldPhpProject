<body>
<div id="main_container">
    <nav id="main_menu">
        <p class="welcome">Welcome <span style="color:beige"><?php echo $_SESSION['username']; ?> </span> GOLD <?php
            if(!isset($_GET['village'])||intval($_GET['village'])>=count($villages))
                $village=0;
            else $village=intval($_GET['village']);
            echo $villages[$village]['gold'];
            //"<img src=".$units[0]['image']." />";
            ?>|
            <input type="button"
                   id="home"
                   class="show"
                   value="Home"/>
            <input type="button"
                   id="logout"
                   class="show"
                   value="Logout"/>

        </p>
    </nav>
    <div id="data_container">
        <?php
        $data['gold']=$villages[$village]['gold'];
        $_SESSION['current_village']=$villages[$village]['id'];
        $data['units']=$units;
        ?>
