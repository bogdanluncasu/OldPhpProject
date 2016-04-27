<div id="barracks" class="building_name">
    <h2>Barracks Level-<?php echo $level_barracks; ?></h2>
</div>
<table class="vis" style="width: 100%">
    <tbody>
    <tr>
        <th style="width: 20%">Unitate</th>
        <th style="min-width: 400px">Necesitate</th>
        <th style="width: 120px">Recrutare</th>
    </tr>


    <?php if ($level_barracks > 0) {
        for ($i = 0; $i < count($units); $i++) { ?>
            <tr>
                <td>
                    <?php echo "<img src=" . $units[$i]['image'] . " title=" . $units[$i]['name'] . "/>" ?>
                </td>
                <td>
                    <div class="recruit_req">
                        <p class="unit_data"><?php echo "Price: " . $units[$i]['price'] . " gold"; ?></p>
                        <p class="unit_data"><?php echo "Time for recruiting: " . floor($units[$i]['time'] / 3600) . "h " . floor($units[$i]['time'] / 60 % 60) . "m " . floor($units[$i]['time'] % 60) . "s"; ?></p>
                    </div>
                </td>
                <td>
                    <input type="number" min="0" max="<?php echo $gold / $units[$i]['price']; ?>"
                           id="u<?php echo $i; ?>"/>
                    <input type="button" id="recruit" value="Recruit"/>
                    <span id="cw">Time</span>

                    <script>
                        if (!localStorage.getItem('shomzTimer'))
                            localStorage.setItem('shomzTimer', new Date().getTime());
                        var timer=<?php echo (strtotime($recruiting[0]['timestamp']) - time());?>;
                        setInterval(function () {
                            timer-=0.5;
                            var date = new Date(timer*1000);
                            var hours = date.getHours();
                            var minutes = "0" + date.getMinutes();
                            var seconds = "0" + date.getSeconds();
                            var formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
                            document.getElementById('cw').textContent = formattedTime;
                        }, 1000);
                    </script>
                </td>
            </tr>

        <?php }
    } ?>


    </tbody>
</table>
    