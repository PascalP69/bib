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
    $book_category = $_POST["book_category"];
    $book_release = $_POST["book_release"];
    $book_ISBN = $_POST["book_ISBN"];
    $book_verlag = $_POST["book_verlag"];
    $book_preis = $_POST["book_preis"];

    // Buch mit den Variablen zur DB hinzufügen
    $sql = "INSERT INTO buch (verlag_ID, kategorie_ID, buchtitel, erscheinungsjahr, ISBN, tagespreis) VALUES ('$book_verlag', '$book_category', '$book_title', '$book_release', '$book_ISBN', '$book_preis')";
    // Query ausführen
    if ($conn->query($sql) === TRUE) {
        echo "Das Buch '$book_title' wurde erfolgreich hinzugefügt.";
    } else {
        echo "Fehler beim Hinzufügen des Buchs: " . $conn->error;
    }
}

$conn->close();
?>