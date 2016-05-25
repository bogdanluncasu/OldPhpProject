<?php
$villages_per_page=5;
$start = $villages_per_page * ((isset($_GET['next'])) ? intval($_GET['next']) : 0);
$stop = (count($villages) - $start > $villages_per_page) ? $start + $villages_per_page : count($villages);
echo "<table class=\"table\" id='table'>
    <thead>
      <tr>
        <th>Village</th>
        <th>Village Main Building</th>
      </tr>
    </thead>
    <tbody>";
for ($i = $start; $i < $stop; $i++) {
    echo "<tr>";
    echo "<td><a href='game?village=".$i."'>" .
        ($i+1) . "- Village</a></td>";
    echo "<td>".$villages[$i]['mainBuilding']."</td>";
    echo "</tr>";
}
echo "</tbody></table>";
echo "<div class='pages' id='rankPages'>";
for ($i = 0; $i < count($villages) / $villages_per_page; $i++) {
    echo "<a href='game?open=villages&next=" . $i . "'>" . ($i + 1) . "</a>";
}
echo "</div>";
