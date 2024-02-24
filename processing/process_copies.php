<?php
session_start();
include('../mysql.php');

// Überprüfen, ob der Benutzer angemeldet ist und ein spezieller Benutzer ist (z. B. Admin).
if (!isset($_SESSION["username"])) {
    header("Location: index.html");
    exit();
}
// Wenn der request ein POST war schreibe die werte aus dem post in variablen
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_title = $_POST["book_title"];
    $book_condition = $_POST["book_condition"];
    $book_amount = $_POST["book_amount"];

    // Exemplar mit den Variablen zur DB hinzufügen
    $sql = "INSERT INTO exemplar (buch_ID, zustand, verfügbarkeit) VALUES ('$book_title', '$book_condition', '1')";

    // $book_amount wird für die Anzahl der Exemplare übergeben, und in einer for loop dann so oft ausgeführt
    for ($i = 1; $i <= $book_amount; $i++) {

        if ($conn->query($sql) === TRUE) {
            echo "Das Exemplar für '$book_title' wurde erfolgreich hinzugefügt.<br>\n";
        } else {
            echo "Fehler beim Hinzufügen des Exemplars: " . $conn->error;
        }
    }
}
$conn->close();
?>