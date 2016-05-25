<?php
function cmp($a, $b)
{
    return $a["points"] > $b["points"];
}

$users_per_page = 5;
if(isset($_POST['json'])){
    $users=$_POST['json'];
}
usort($users, "cmp");
$r_users = array_reverse($users);

$start = $users_per_page * ((isset($_GET['next'])) ? intval($_GET['next']) : 0);
$stop = (count($r_users) - $start > $users_per_page) ? $start + $users_per_page : count($r_users);
echo "<div class=\"searchBox\">
    <input type=\"text\" id=\"search\"/> 
    </div>";
echo "<table class=\"table\" id='table'>
    <thead>
      <tr>
        <th>Rank</th>
        <th>Username</th>
        <th>Points</th>
      </tr>
    </thead>
    <tbody>";
for ($i = $start; $i < $stop; $i++) {
    echo "<tr>";
    echo "<td>" . ($i + 1) . "</td>";
    echo "<td><a href='game?profile=" . $r_users[$i]['userId'] . "'>" .
        $r_users[$i]['username'] . "</a></td>";
    echo "<td>" . $r_users[$i]['points'] . "</td>";
    echo "</tr>";
}
echo "</tbody></table>";
echo "<div class='pages' id='rankPages'>";
for ($i = 0; $i < count($r_users) / $users_per_page; $i++) {
    echo "<a href='game?open=ranking&next=" . $i . "'>" . ($i + 1) . "</a>";
}
echo "</div>";
