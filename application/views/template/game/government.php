
<div id="government" class="building_name">
    <h2>Government Level- <?php echo $level_government; ?></h2>
</div>

<table class="vis" style="width: 100%">
    <tbody>

    <?php $recruiting=$recruiting_units;
    $gold=$villages[$village]['gold'];
    if ($level_government > 0) {
    for ($i = 0; $i < count($units); $i++) { if($units[$i]['type']==1){ ?>
    <tr>
        <td>
            <?php echo "<img src=" . $units[$i]['image'] . " title=" . $units[$i]['name'] . " width = '100px'/>" ?>
        </td>

        <td>
            <div class="recruit_req">
                <p class="unit_data"><?php echo "Current number of units: " . $current_units[$units[$i]['name']]; ?></p>
                <p class="unit_data"><?php echo "Price: " . $units[$i]['price'] . " gold"; ?></p>
                <p class="unit_data"><?php echo "Time for recruiting: " . floor($units[$i]['time'] / 3600) . "h " . floor($units[$i]['time'] / 60 % 60) . "m " . floor($units[$i]['time'] % 60) . "s"; ?></p>
            </div>
        </td>
        <td>


            <?php
            $unit_name='0';
            foreach ($recruiting as $unit) {
                if($unit['unitName']==$units[$i]['name']) {
                    $unit_name = $unit['unitName'];
                    $unit_time = $unit['timestamp'];
                }

            }


            if ($unit_name=='0') {
                if($current_units[$units[$i]['name']] == 0)
            {?>
                <form action="game/create_governors/<?php echo $i; ?>" method="post">
                    <input type="submit" id="recruit<?php echo $i; ?>" value="Recruit"/>
                </form>
            <?php }
            } else { ?>
                <span id="cw<?php echo $i;?>">Time</span>
                <script>
                    if (!localStorage.getItem('shomzTimer'))
                        localStorage.setItem('shomzTimer', new Date().getTime());

                    var timer<?php echo $i; ?> =<?php echo(strtotime($unit_time) - time());?>;

                    setInterval(function () {
                        if(timer<?php echo $i; ?><=1){
                            $(location).attr("href","game/verify_governers");
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
    } ?>


    </tbody>
</table>