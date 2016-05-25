<div id="main" class="building_name">
    <h2>Main Building Level-<?php echo $level_main;?></h2>

</div>
<table class="vis" style="width: 100%">
    <tbody>

    <?php $recruiting=$recruiting_units;
    $gold=$villages[$village]['gold'];

        for ($i = 0; $i < count($buildings); $i++) { if($level_main>=$buildings[$i]['min_level']){ 
            $price =$buildings[$i]['price']+ $buildings[$i]['price']*$i/25;?>
            <tr>
                <td>
                    <?php echo "<img src=" . $buildings[$i]['image'] . " title=" . $buildings[$i]['name'] . "/>" ?>
                </td>

                <td>
                    <div class="recruit_req">
                        <p class="unit_data"><?php echo "Current level: " . $buildings[$i]['name']; ?></p>
                        <p class="unit_data"><?php echo "Price: " . $price . " gold"; ?></p>
                        <p class="unit_data"><?php
                            $time=($buildings[$i]['time'] * (21-$level_main))-($buildings[$i]['time'] * (21-$level_main))/50;
                            echo "Time for building: " . floor($time / 3600) . "h " . floor(  $time/60%60) . "m " . floor($time% 60) . "s"; ?></p>
                    </div>
                </td>
                <td>


                    <?php
                    $building_name='0';
                    foreach ($constructing_building as $building) {
                        if($building['unitName']==$buildings[$i]['name']) {
                            $building_name = $building['buildingName'];
                            $building_time = $building['timestamp'];
                        }
                    }
                    if($building_name!=0) {
                    if ($villages[$village]['cazarma'] <= $buildings[$i]['max_level']) { ?>
                    <form action="game/upgrade/<?php echo $building_name; ?>" method="post"> 
                        <input type="submit" value="Upgrade" id="upgrade"/></form>
                    <?php }
                    }else { ?>
                        <span id="cw<?php echo $i;?>">Time</span>
                        <script>
                            if (!localStorage.getItem('shomzTimer'))
                                localStorage.setItem('shomzTimer', new Date().getTime());

                            var timer<?php echo $i; ?> =<?php echo(strtotime($building_time) - time());?>;

                            setInterval(function () {
                                if(timer<?php echo $i; ?><=1){
                                    $(location).attr("href","game/verify");
                                }
                                timer<?php echo $i; ?> -= 1;
                                var date = new Date(timer<?php echo $i; ?> * 1000);
                                var hours = date.getHours();
                                var minutes = "0" + date.getMinutes();
                                var seconds = "0" + date.getSeconds();
                                var formattedTime = hours-2 + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
                                document.getElementById('cw<?php echo $i;?>').textContent = formattedTime;
                            }, 1000);
                        </script>
                    <?php } ?>
                </td>

            </tr>

        <?php }}
     ?>


    </tbody>
</table>
