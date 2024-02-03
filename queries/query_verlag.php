<?php

$sql = "SELECT * FROM verlag";
$result = $conn->query($sql);
echo '<h2>Verlagsinformationen</h2>';

echo '<table width="100%" bgcolor="#fff" align="center" style="text-align:center;" border=1>';
echo '<tr bgcolor="#003b87" style="color: #fff;"><td>Verlag ID</td><td>Verlagname</td><td>Ort</td></tr>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
            echo '<tr>';
                echo '<td>' . $row["verlag_ID"] . '</td>';
                echo '<td>' . $row["verlagname"] . '</td>';
                echo '<td>' . $row["ort_ID"] . '</td>';

            echo '</tr>';

        }
        echo '</table>';

        } else {
        echo "Keine Daten gefunden.";
}
?>