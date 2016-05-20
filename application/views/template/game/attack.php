<div class="attack">

	<input id = "x" type="number" value="<?php if(isset($_GET["attackx"]))
    echo  $_GET["attackx"]; else echo 0; ?>" name = "attackx"/>
	<input id = "y" type="number" value="<?php if(isset($_GET["attacky"]))
        echo  $_GET["attacky"]; else echo 0; ?>" name = "attacky" />
    <br/>
    <?php
        for($i=0; $i < count($units); $i++){
            echo $units[$i]['name'];
    ?>
    <input id = "u<?php echo $i; ?>" type="number" value="0"/><br/>
    <?php }?>

    <input type="button" value="Attack" id = "attack" />

</div>
<div id = "error"></div>

<?php

    for($i=0; $i<count($current_attacks); $i++){
        echo $current_attacks[$i]['timestamp'];
    }
