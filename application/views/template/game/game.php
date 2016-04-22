<body onload="init();">
<?php
//print_r($villages);
if (isset($_SESSION['username'])){
    if ($_SESSION['first'] != 0) {
        ?>
        <div id="main_container">
            <nav id="main_menu">
                <p class="welcome">Welcome <span style="color:beige"><?php echo $_SESSION['username']; ?> </span> GOLD <?php
                    if(!isset($_GET['village'])||intval($_GET['village'])>=count($villages))
                        $village=0;
                    else $village=intval($_GET['village']);
                    echo $villages[$village]['gold']; ?>|
                    <input type="button"
                           id="logout"
                           class="show"
                           value="Logout"/>
                </p>
            </nav>
            <div id="data_container">
                <?php require 'js/createMap.php'; ?>
                <?php if(isset($_GET['open'])&&$_GET['open']=='map'){ ?>
                    <canvas id="mapCanvas" width="600" height="418" style="margin-left:auto;margin-right:auto">
                        alternate content
                    </canvas>
              <?php  } else if (isset($_GET['open'])&&$_GET['open']=='barracks'){
                    $data['level_barracks']=$villages[$village]['cazarma'];
                    $this->load->view("template/game/barracks.php",$data);
                }else if (isset($_GET['open'])&&$_GET['open']=='main'){
                    $data['level_main']=$villages[$village]['mainBuilding'];
                    $this->load->view("template/game/main.php",$data);
                }else if (isset($_GET['open'])&&$_GET['open']=='farm'){
                    $data['level_farm']=$villages[$village]['ferma'];
                    $this->load->view("template/game/farm.php",$data);
                }else{?>
                    <?php require 'js/createGame.php'; ?>
                    <canvas id="gameCanvas" width="600" height="418" style="margin-left:auto;margin-right:auto">
                        alternate content
                    </canvas>
                <?php } ?>
              
            </div>
        </div>
    <?php } else { ?>

        <div id="main_container">
            <nav id="main_menu">
                <p class="welcome">Welcome <span style="color:beige"><?php echo $_SESSION['username']; ?> </span>| <input type="button"
                                                                                                          id="logout"
                                                                                                          class="show"
                                                                                                          value="Logout"/>
                </p>
            </nav>
            <div id="data_container">
                <div class="centered"><p class="welcome">Please choose your Hero</p></div>
                <div id="choose">
                    <input type="radio" class="hideradiobutton" name="choose" id="barbar" checked="true"/>
                    <label for="barbar"><img class="pict" src="resources/1.png" alt="I will hunt you down"/></label>
                    <input type="radio" class="hideradiobutton" name="choose" id="smart"/>
                    <label for="smart"><img class="pict" src="resources/2.png" alt=""/></label>
                    <input type="radio" class="hideradiobutton" name="choose" id="mage"/>
                    <label for="mage"><img class="pict" src="resources/3.png"
                                           alt="My magic will tear you apart"/></label>
                </div>
                <input  type="button" class="show" value="Let's Fight" id="fight"/>
                <p class="centered welcome" >Folosesteti puterile magice pentru a-ti alege #eroul cu intelepciune</p>
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