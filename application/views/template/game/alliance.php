<?php
if (count($alliance) != 0) {
    $users_per_page=6;
    $start = $users_per_page * ((isset($_GET['next'])) ? intval($_GET['next']) : 0);
    $stop = (count($alliance) - $start > $users_per_page) ? $start + $users_per_page : count($alliance);
    $isowner=($alliance[0]['owner']==$_SESSION['id']);
    echo "<div id='alliancename'><h2>Welcome to
    <span class='welcome'>" . $alliance[0]['alliance'] . "</span></h2>
    </div>";
    echo "<table class=\"table\" id='table'>
    <thead>
      <tr>
        <th>Rank</th>
        <th>Username</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>";
    for ($i = $start; $i < $stop; $i++) {
        echo "<tr  id='ally".$i."'>";
        echo "<td>" . (($alliance[$i]['owner']==$alliance[$i]['id'])?"Owner":"Member"). "</td>";
        echo "<td><a href='game?profile=" . $alliance[$i]['id'] . "'>" .
            $alliance[$i]['username'] . "</a></td>";
        if(($isowner||$_SESSION['id']==$alliance[$i]['id'])&&$alliance[$i]['owner']!=$alliance[$i]['id']){
            echo "<td><input type='button' value='X' onclick='removeFromAlliance(".$i.",".$alliance[$i]['id'].")'/></td>";
        }else echo "<td><input type='button' value='Abolish' 
        onclick='abolishAlliance(".$alliance[$i]['allianceId'].")'/></td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
    echo "<div class='pages' id='rankPages'>";
    for ($i = 0; $i < count($alliance) / $users_per_page; $i++) {
        echo "<a href='game?open=alliance&next=" . $i . "'>" . ($i + 1) . "</a>";
    }
    echo "</div>";
    if(count($request)>0&&$isowner){
        echo "<table class=\"table\" id='table'>
    <thead>
      <tr>
        <th>Username</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>";
        for($i = 0; $i < count($request); $i++) {
            echo "<tr  id='req".$i."'>";
            echo "<td><a href='game?profile=" . $request[$i]['id'] . "'>" .
                $request[$i]['username'] . "</a></td>";
            echo "<td><input type='button' value='V' onclick='addToAlliance(".$i.",".$request[$i]['id'].")'/>
                <input type='button' value='X' onclick='removeRequestFromAlliance(".$i.",".$request[$i]['id'].")'/></td>";
            echo "</tr>";
        }
    }
    echo "</tbody></table>";
} else {
    $alliances_per_page=6;
    $start = $alliances_per_page * ((isset($_GET['next'])) ? intval($_GET['next']) : 0);
    $stop = (count($allAlliances) - $start > $alliances_per_page) ?
        $start + $alliances_per_page : count($allAlliances);

    echo "<table class=\"table\" id='table'>
    <thead>
      <tr>
        <th>Alliance</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>";
    for ($i = $start; $i < $stop; $i++) {
        echo "<tr  id='apply".$i."'>";
        echo "<td>" .$allAlliances[$i]['name']. "</td>";
        echo "<td><input type='button' value='Apply' onclick='apply(".$allAlliances[$i]['id'].")' /></td>";
        echo "</tr>";
    }
    echo "<tr  id='create'>";
    echo "<td><input type='text' id='allianceName' placeholder='Alliance Name' /></td>";
    echo "<td><input type='button' value='Create' id='createAlliance' /></td>";
    echo "</tr>";

    echo "</tbody></table>";
    echo "<div class='pages' id='rankPages'>";
    for ($i = 0; $i < count($allAlliances) / $alliances_per_page; $i++) {
        echo "<a href='game?open=alliance&next=" . $i . "'>" . ($i + 1) . "</a>";
    }
    echo "</div>";
};