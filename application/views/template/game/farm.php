
<div id="Farm" class="building_name">
    <h2>Farm Level-<?php echo $level_farm;?></h2>
</div>

<?php

    $x = 2+(int)((2+$level_farm)/5);
    $a = "You have $x farmers ";
    echo "<div style='float:none ;color:#FF0000; font-size: larger'>" . $a  ."</div>";
    $lineofstring = 'farmer.png';
    $image = '<img src="resources/' . $lineofstring . '">';
    for ($i = 1; $i <= $x; $i++)
        echo($image);
?>

