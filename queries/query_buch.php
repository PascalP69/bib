<?php

$sql = "SELECT * FROM buch";
$result = $conn->query($sql);
echo '<h2>Bücher</h2>';

echo '<table width="100%" bgcolor="#fff" align="center" style="text-align:center;" border=1>';
echo '<tr bgcolor="#003b87" style="color: #fff;"><td>Buch ID</td><td>Titel</td><td>Erscheinungsjahr</td><td>ISBN</td><td>Tagespreis</td></tr>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
            echo '<tr>';
                echo '<td>' . $row["buch_ID"] . '</td>';
                echo '<td>' . $row["buchtitel"] . '</td>';
                echo '<td>' . $row["erscheinungsjahr"] . '</td>';
                echo '<td>' . $row["ISBN"] . '</td>';
                echo '<td>' . $row["tagespreis"] . '</td>';

            echo '</tr>';

        }
        echo '</table>';

        } else {
        echo "Keine Daten gefunden.";
}
?>