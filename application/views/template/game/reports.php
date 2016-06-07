<?php
$reports_per_page=6;
$start = $reports_per_page * ((isset($_GET['next'])) ? intval($_GET['next']) : 0);
$stop = (count($reports) - $start > $reports_per_page) ? $start + $reports_per_page : count($reports);
echo "<table class=\"table\" id='table'>
    <thead>
      <tr>
        <th>VillageIdAtt</th>
        <th>VillageIdDef</th>
        <th>Report</th>
      </tr>
    </thead>
    <tbody>";
for ($i = $start; $i < $stop; $i++) {
    echo "<tr>";
    echo "<td>" . $reports[$i]->villageIdAtt . "</td>";
    echo "<td>".$reports[$i]->villageIdDef."</td>";
    echo "<td>" .$reports[$i]->Descriere . "</td>";
    echo "</tr>";
}
echo "</tbody></table>";
echo "<div class='pages' id='rankPages'>";
for ($i = 0; $i < count($reports) / $reports_per_page; $i++) {
    echo "<a href='game?open=reports&next=" . $i . "'>" . ($i + 1) . "</a>";
}
echo "</div>";