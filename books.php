<?php
session_start();
include('mysql.php');

// Überprüfen, ob der Benutzer angemeldet ist.
if (!isset($_SESSION["username"])) {
    header("Location: books.php");
    exit();
}

// Prüfen, ob das Formular abgeschickt wurde und der POST 'ausleihe_taetigen' beinhaltet
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ausleihe_taetigen']) && isset($_POST['form_submitted'])) {
    if (isset($_POST['selected_books'])) {
        $selected_books = $_POST['selected_books'];

        //Holen des eingeloggten Usernamen und das Extrahieren der KundenID durch SQL Abfrage
        $username = $_SESSION["username"];
        $sql_get = "SELECT * FROM kunde WHERE email = '$username'";
        $result_get = $conn->query($sql_get);


        if ($result_get->num_rows > 0) {
            $row = $result_get->fetch_assoc();

            // k_id auf die user ID des eingeloggten nutzers setzen und sql ausführen um neuen Auftrag hinzuzufügen (dummy erstmal)
            $k_id = $row['kunde_ID'];
            foreach ($selected_books as $exemplar_id) {
                $sql_book = "SELECT * FROM buch, exemplar WHERE buch.buch_ID = exemplar.buch_ID and exemplar.exemplar_ID = $exemplar_id";
                $result_book = $conn->query($sql_book);
                if ($result_book->num_rows > 0) {
                    $row_book = $result_book->fetch_assoc();
                }
                $b_preis = $row_book["tagespreis"];
                // Einen verleihvorgang hinzufügen für das jeweilige exemplar, einzeln da sie auch potentiell einzeln zurückgegeben werden.
                $sql_get = "INSERT INTO verleihvorgang (kunden_ID, ausleihdatum, rückgabestatus, preis, zahlungsstatus, exemplar_ID) VALUES ('$k_id', now(),  '0', '$b_preis', '0', '$exemplar_id')";
                if ($conn->query($sql_get) === TRUE) {
                    // Success Debug message auskommentiert
                    //echo "dfs";
                    //echo "<script>UIkit.notification('Ausleihen erfolgreich', 'success');</script>";
                } else {
                    echo "Fehler beim Ausleihen: " . $conn->error . " END";
                }
            }
        }
        // Exemplare aus der Datenbank auf 0 setzen um sie nicht verfügbar zu machen, da sie ausgeliehen wurden.
        foreach ($selected_books as $exemplar_id) {
            $update_sql = "UPDATE exemplar SET verfügbarkeit = 0 WHERE exemplar_ID = $exemplar_id";
            $conn->query($update_sql);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKR Bibliothek - Buch Übersicht</title>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="css/uikit.min.css" />

    <!-- Optional: Theme CSS -->
    <link rel="stylesheet" href="css/uikit-rtl.min.css" />

    <!-- UIkit JS -->
    <script src="js/uikit.min.js"></script>
    <script src="js/uikit-icons.min.js"></script>
</head>

<script>
    // Event listener musste benutzt werden weil es wohl timing probleme beim UIKit JS gibt
    document.addEventListener("DOMContentLoaded", function () {
        // Überprüfen, ob das Formular abgeschickt wurde und die Notify-Nachricht anzeigen
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ausleihe_taetigen']) && isset($_POST['form_submitted'])) {
            if (isset($_POST['selected_books'])) {
                echo "UIkit.notification('<span uk-icon=\'icon: check\'></span> Ausleihen erfolgreich!', { status: 'success', timeout: '2000'});";
            } else {
                echo "UIkit.notification('<span uk-icon=\'icon: close\'></span> Keine Bücher ausgewählt!', { status: 'danger', timeout: '2000'});";
            }

        }
        ?>
    });

    function searchFunc() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<body>

    <?php
    include('templates/nav.php');
    ?>
    <form method="post" action="">
        <div class="uk-grid uk-child-width-1-1">
            <div>

                <h2>Bücher Leihen</h2>
                <div class="uk-margin">
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: search"></span>
                        <input class="uk-input uk-search-input" type="text" id="myInput" onkeyup="searchFunc()"
                            placeholder="Buchtitel suchen...">
                    </div>
                </div>
                <table class="uk-table uk-table-striped uk-table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th style="text-align: center">Titel</th>
                            <th style="text-align: center">Zustand</th>
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
                                echo '<td style="text-align: center">' . $row["buchtitel"] . '</td>';
                                echo '<td style="text-align: center">' . $row["zustand"] . '</td>';
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
                <button class="uk-button uk-button-primary" type="submit" name="ausleihe_taetigen">Ausleihe
                    tätigen</button>
            </div>
        </div>
        <input type="hidden" name="form_submitted" value="1">
    </form>

</body>

</html>