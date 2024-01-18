<?php

$sql = "SELECT * FROM kunde";
$result = $conn->query($sql);
echo '<h2>Benutzerdaten</h2>';

echo '<table width="100%" bgcolor="#fff" align="center" style="text-align:center;" border=1>';
echo '<tr bgcolor="#003b87" style="color: #fff;"><td>Kundenummer</td><td>Name</td><td>E-Mail</td><td>Geburtstag</td><td>Telefon</td><td>Wohnort</td></tr>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
            echo '<tr>';
                echo '<td>' . $row["kunde_ID"] . '</td>';
                echo '<td>' . $row["name"] . '</td>';
                echo '<td>' . $row["email"] . '</td>';
                echo '<td>' . $row["geburtsdatum"] . '</td>';
                echo '<td>' . $row["telefon"] . '</td>';
                echo '<td>' . $row["ort_ID"] . '</td>';
            echo '</tr>';

        }
        echo '</table>';

        } else {
        echo "Keine Daten gefunden.";
}
?>