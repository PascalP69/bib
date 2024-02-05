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
    $book_category = $_POST["book_category"];
    $book_release = $_POST["book_release"];
    $book_ISBN = $_POST["book_ISBN"];
    $book_verlag = $_POST["book_verlag"];
    $book_preis = $_POST["book_preis"];




    // Hier sollte das Buch zur Datenbank hinzugefügt werden.
    $sql = "INSERT INTO buch (verlag_ID, kategorie_ID, buchtitel, erscheinungsjahr, ISBN, tagespreis) VALUES ('$book_verlag', '$book_category', '$book_title', '$book_release', '$book_ISBN', '$book_preis')";

    if ($conn->query($sql) === TRUE) {
        echo "Das Buch '$book_title' wurde erfolgreich hinzugefügt.";
    } else {
        echo "Fehler beim Hinzufügen des Buchs: " . $conn->error;
    }
}

$conn->close();
?>