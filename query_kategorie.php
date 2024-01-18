<?php

$sql = "SELECT * FROM kategorie";
$result = $conn->query($sql);
echo '<h2>Kategorien</h2>';

echo '<table width="100%" bgcolor="#fff" align="center" style="text-align:center;" border=1>';
echo '<tr bgcolor="#003b87" style="color: #fff;"><td>Kategorie ID</td><td>Kategoriename</td></tr>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
            echo '<tr>';
                echo '<td>' . $row["kategorie_ID"] . '</td>';
                echo '<td>' . $row["name"] . '</td>';

            echo '</tr>';

        }
        echo '</table>';

        } else {
        echo "Keine Daten gefunden.";
}
?>