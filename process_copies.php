<?php
session_start();
include('mysql.php');

// Überprüfen, ob der Benutzer angemeldet ist und ein spezieller Benutzer ist (z. B. Admin).
if (!isset($_SESSION["username"])) {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_title = $_POST["book_title"];
    $book_condition = $_POST["book_condition"];
    $book_amount = $_POST["book_amount"];



    $sql = "INSERT INTO exemplar (buch_ID, zustand, verfügbarkeit) VALUES ('$book_title', '$book_condition', '1')";
    // Hier sollte das Buch zur Datenbank hinzugefügt werden.
    for ($i = 1; $i <= 5; $i++) {

        if ($conn->query($sql) === TRUE) {
            echo "Das Exemplar für '$book_title' wurde erfolgreich hinzugefügt.";
        } else {
            echo "Fehler beim Hinzufügen des Exemplars: " . $conn->error;
        }
    }



}

$conn->close();
?>