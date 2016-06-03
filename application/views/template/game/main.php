<div id="main" class="building_name">
    <h2>Main Building Level-<?php echo $level_main;?></h2>

</div>
<table class="vis" style="width: 100%">
    <tbody>

    <?php
    $gold=$villages[$village]['gold'];

        for ($i = 0; $i < count($buildings); $i++) { if($level_main>=$buildings[$i]['min_level']){
            $price =$buildings[$i]['price']*
                $villages[(isset($_POST['village'])?$_POST['village']:0)][$buildings[$i]['name']]
                + $buildings[$i]['price']/25;?>
            <tr>
                <td>
                    <?php echo "<img src=" . $buildings[$i]['image'] . " title=" . $buildings[$i]['name'] . "/>" ?>
                </td>

                <td>
                    <div class="recruit_req">
                        <p class="unit_data"><?php echo "Current level: " . $buildings[$i]['name']; ?></p>
                        <p class="unit_data"><?php echo "Price: " . intval($price) . " gold"; ?></p>
                        <p class="unit_data"><?php
                            $time=($buildings[$i]['time'] * (21-$level_main))-($buildings[$i]['time'] * (21-$level_main))/50;
                            echo "Time for building: " . floor($time / 3600) . "h " . floor(  $time/60%60) . "m " . floor($time% 60) . "s"; ?></p>

                    </div>
                </td>
                <td>

                    <?php
                    $buildingName='0';
                    foreach($constructing_building as $building)
                    {
                        if($building['buildingName']==$buildings[$i]['name'])
                        {$buildingName=$buildings[$i]['name'];
                            $buildingTime=$building['timestamp'];
                            }

                    }

                    if ($buildingName=='0') { ?>
                        <input type ="button" id="upgrade" value="Upgrade" onclick="upgrade('<?php echo $buildings[$i]['name']; ?>')"/>
                        <input type ="button" id="downgrade" value="Downgrade" onclick="downgrade('<?php echo $buildings[$i]['name']; ?>')"/>
                    <?php }
                    else { ?>
                        <span id="cw<?php echo $i;?>">Time</span>
                        <script>
                            if (!localStorage.getItem('shomzTimer'))
                                localStorage.setItem('shomzTimer', new Date().getTime());

                            var timer<?php echo $i; ?> =<?php echo(strtotime($buildingTime) - time());?>;

                            setInterval(function () {
                                if(timer<?php echo $i; ?><=1){
                                    $(location).attr("href","game/verifyBuildings");
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
