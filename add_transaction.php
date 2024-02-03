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

    // Hier sollte das Buch zur Datenbank hinzugefügt werden.
    $sql = "INSERT INTO verleihvorgang (kunden_ID, ausleihdatum, rückgabestatus, preis,zahlungsstatus) VALUES ('$book_verlag', '$book_category', '$book_title', '$book_release', '$book_ISBN', '0')";

    if ($conn->query($sql) === TRUE) {
        echo "Ausleihvorgang erfolgreich!";
    } else {
        echo "Fehler beim Ausleihen: " . $conn->error;
    }
}

$conn->close();
?>