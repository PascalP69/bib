<?php
session_start();
include('../mysql.php');

// Überprüfen, ob der Benutzer angemeldet ist.
if (!isset($_SESSION["username"])) {
    header("Location: process_resolve_loans.php");
    exit();
}

// Prüfen, ob das Formular abgeschickt wurde
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rückgabe_taetigen']) && isset($_POST['form_submitted'])) {
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
            /*
            foreach ($selected_books as $exemplar_id) {
                $sql_book = "SELECT * FROM buch, exemplar WHERE buch.buch_ID = exemplar.buch_ID and exemplar.exemplar_ID = $exemplar_id";
                $result_book = $conn->query($sql_book);
                if ($result_book->num_rows > 0) {
                    $row_book = $result_book->fetch_assoc();
                }
                $b_preis = $row_book["tagespreis"];
                $sql_get = "INSERT INTO verleihvorgang (kunden_ID, ausleihdatum, rückgabestatus, preis, zahlungsstatus, exemplar_ID) VALUES ('$k_id', now(),  '0', '$b_preis', '0', '$exemplar_id')";
                if ($conn->que  ry($sql_get) === TRUE) {
                    echo "Ausleihvorgang erfolgreich!";
                } else {
                    echo "Fehler beim Ausleihen: " . $conn->error . " END";
                }

            }*/
        }
        // Exemplare aus der Datenbank auf 0 setzen um sie nicht verfügbar zu machen, da sie ausgeliehen wurden.
        foreach ($selected_books as $exemplar_id) {
            $update_sql = "UPDATE exemplar SET verfügbarkeit = 1 WHERE exemplar_ID = $exemplar_id";
            $conn->query($update_sql);
        }
    }
}

?>