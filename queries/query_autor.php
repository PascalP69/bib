<?php

$sql = "SELECT * FROM autor";
$result = $conn->query($sql);

echo '
<h2>Autoren</h2>
<div class="uk-inline">
<div class="uk-position-center"></div>


<table class="uk-table uk-table-divider uk-table-hover">

    <thead>
        <tr>
            <th>Autoren ID</th>
            <th>Name</th>
            <th>Vorname</th>
        </tr>
    </thead>
<tr bgcolor="#003b87" style="color: #fff"></tr>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
            echo '
            <tr>
                <td>' . $row["autor_ID"] . '</td>
                <td>' . $row["name"] . '</td>
                <td>' . $row["vorname"] . '</td>
            </tr>';

        }
        echo '</table>';

        } else {
        echo "Keine Daten gefunden.";
}
echo '</div>';
?>