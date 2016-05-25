<div id="Fairy" class="building_name">
    <h2>Fair Level-<?php echo $fair['targ'];?></h2>
</div>
<?php

echo "<table class=\"table\">
    <thead>
      <tr>
        <th>Item Image</th>
        <th>Item Name</th>
        <th>Item Price</th>
        <th>Equip</th>
      </tr>
    </thead>
    <tbody>";

foreach($items as $item){
    echo "<tr>";
    echo "<td><img src=\"".$item['image']."\" width=\"100px\"/></td>";
    echo "<td>".$item['name']."<p>".$item['info']."</p></td>";
    echo "<td>".$item['price']."</td>";
    if($item['type']==2)$bool=$current_units[$item['name']]!=1;
    else $bool=$item['name']!=$equiped;

    if($bool) {
        echo "<td><input type='button' value='Equip' onclick='equip(" . json_encode($item) . ")'/></td>";
    }else{
        echo "<td>Equiped</td>";
    }
    echo "</tr>";
}
echo "</table>";