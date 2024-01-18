<?php
session_start();
include('mysql.php');

// Überprüfen, ob der Benutzer angemeldet ist.
if (!isset($_SESSION["username"])) {
    header("Location: index.html");
    
    exit();
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/uikit.min.css" />
        <script src="js/uikit.min.js"></script>
        <script src="js/uikit-icons.min.js"></script>
    <title>Bibliothek - Ausleihbare Bücher</title>
</head>
<body>
<div class="uk-container uk-margin-large-left uk-margin-large-right">
    <h1>Ausleihbare Bücher</h1>
    
    <?php
        $sql = "SELECT * FROM buch";
        $result = $conn->query($sql);

        echo '<h2>Verfügbare Bücher</h2>';

        echo '<table class="uk-table uk-table-striped uk-table-hover">';
        echo '<thead>
                <tr>
                    <th>Buch ID</th>
                    <th>Titel</th>
                    <th>Erscheinungsjahr</th>
                    <th>ISBN</th>
                    <th>Tagespreis</th>
                </tr>
            </thead>
            ';

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


                // Hier kannst du die Daten verwenden, z.B. ausgeben
                //echo "ID: " . $row["kunde_ID"]. " - Name: " . $row["name"]. " - Email: " . $row["email"]. "<br>";

                } else {
                echo "Keine Daten gefunden.";
        }

    ?>
    </div>
</body>
</html>