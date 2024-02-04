<?php
session_start();
include('mysql.php');

// Überprüfen, ob der Benutzer angemeldet ist.
if (!isset($_SESSION["username"])) {
    header("Location: books.php");
    exit();
}

// Prüfen, ob das Formular abgeschickt wurde
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

            $ex_string = "";
            $k_id = $row['kunde_ID'];
            //$date = "2022-01-01";
            foreach ($selected_books as $exemplar_id) {
                $sql_book = "SELECT * FROM buch, exemplar WHERE buch.buch_ID = exemplar.buch_ID and exemplar.exemplar_ID = $exemplar_id";
                $result_book = $conn->query($sql_book);
                if ($result_book->num_rows > 0) {
                    $row_book = $result_book->fetch_assoc();
                }
                $b_preis = $row_book["tagespreis"];
                $sql_get = "INSERT INTO verleihvorgang (kunden_ID, ausleihdatum, rückgabestatus, preis, zahlungsstatus, exemplar_ID) VALUES ('$k_id', now(),  '0', '$b_preis', '0', '$exemplar_id')";
                if ($conn->query($sql_get) === TRUE) {
                    echo "Ausleihvorgang erfolgreich!";
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

<?php
        include('templates/head.php');
?>

<body>
    
        <?php
            include('templates/header.php');
            include('templates/nav.php');
        ?>
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
    
</body>

</html>