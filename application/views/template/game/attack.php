<div class="attack">
    <div id="coord">
        <input type="number" id="x" value="<?php if(isset($_GET["attackx"]))
            echo  $_GET["attackx"]; else echo 0; ?>"/>
        <input type="number" id="y" value="<?php if(isset($_GET["attacky"]))
            echo  $_GET["attacky"]; else echo 0; ?>"/>
    </div>
   <?php


   echo "<table class=\"table\" id='table'>
        <thead>
        <tr>
            <th>Rank</th>
            <th>Username</th>
            <th>Points</th>
        </tr>
        </thead>
        <tbody>";
        for ($i = 0; $i < count($units); $i++) {
        echo "<tr>";
            echo "<td><img src='".$units[$i]['image']."' width='178px' height='100px'/></td>";
            echo "<td>" . $units[$i]['name'] . "</td>";
            echo "<td><input type='number' id='u".$i."' value='0' min='0'/></td>";
            echo "</tr>";
        }
        echo "</tbody></table>"; ?>

        <input type="button" value="Attack" id = "attack" />
  

</div>
<div id = "error"></div>

<?php

    for($i=0; $i<count($current_attacks); $i++){
        echo $current_attacks[$i]['timestamp'];
    }
