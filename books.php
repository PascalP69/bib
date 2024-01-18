<?php
session_start();
include('mysql.php');

// Überprüfen, ob der Benutzer angemeldet ist.
if (!isset($_SESSION["username"])) {
    header("Location: index.html");
    exit();
}

// Prüfen, ob das Formular abgeschickt wurde
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ausleihe_taetigen']) && isset($_POST['form_submitted'])) {
    // Hier kannst du die ausgewählten Buch-IDs verarbeiten
    if (isset($_POST['selected_books'])) {
        $selected_books = $_POST['selected_books'];
        // Jetzt kannst du die Buch-IDs in der Datenbank verarbeiten, z.B. auf "nicht verfügbar" setzen
        foreach ($selected_books as $exemplar_id) {

            // Füge hier deine Logik für die Datenbankaktualisierung ein
            // Beispiel: $update_sql = "UPDATE exemplar SET verfügbarkeit = 0 WHERE exemplar_id = $exemplar_id";
            $update_sql = "UPDATE exemplar SET verfügbarkeit = 0 WHERE exemplar_ID = $exemplar_id";
            $conn->query($update_sql);
        }
    }
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
        <form method="post" action="">
        <div class="uk-grid uk-child-width-1-1">
            <div>

                <h2>Verfügbare Bücher</h2>
                <table class="uk-table uk-table-striped uk-table-hover">
                    <thead>
                        <tr>
                            <th style="text-align: center">Exemplar ID</th>
                            <th style="text-align: center">Zustand</th>
                            <th style="text-align: center">Titel</th>
                            <th style="text-align: center">Erscheinungsjahr</th>
                            <th style="text-align: center">ISBN</th>
                            <th style="text-align: center">Tagespreis</th>
                            <th style="text-align: center">Ausleihen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM buch, exemplar where buch.buch_id = exemplar.buch_id and exemplar.verfügbarkeit = 1";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td style="text-align: center">' . $row["exemplar_ID"] . '</td>';
                                echo '<td style="text-align: center">' . $row["zustand"] . '</td>';
                                echo '<td style="text-align: center">' . $row["buchtitel"] . '</td>';
                                echo '<td style="text-align: center">' . $row["erscheinungsjahr"] . '</td>';
                                echo '<td style="text-align: center">' . $row["ISBN"] . '</td>';
                                echo '<td style="text-align: center">' . $row["tagespreis"] . '€</td>';
                                echo '<td style="text-align: center"><input class="uk-checkbox" type="checkbox" name="selected_books[]" value="' . $row["exemplar_ID"] . '"></td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="7">Keine Daten gefunden.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="uk-flex uk-flex-right">
                    <button class="uk-button uk-button-primary" type="submit" name="ausleihe_taetigen">Ausleihe tätigen</button>
                </div>
        </div>
        <input type="hidden" name="form_submitted" value="1">
                    </form>
    </div>
</body>

</html>