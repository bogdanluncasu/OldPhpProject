<?php if($_SESSION['first']==0) { ?>

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

<?php } ?>