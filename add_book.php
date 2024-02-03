<?php
session_start();
include('mysql.php');

// Überprüfen, ob der Benutzer angemeldet ist und ein spezieller Benutzer ist (z. B. Admin).
if (!isset($_SESSION["username"]) || $_SESSION["username"] != "admin@bib.de") {
    header("Location: add_book.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/uikit.min.css" />
    <script src="js/uikit.min.js"></script>
    <script src="js/uikit-icons.min.js"></script>
    <title>Bibliothek - Neues Buch hinzufügen</title>
</head>
<body>
    <?php
    include('templates/header.php');
    include('templates/nav.php');
    ?>
    <form action="process_book.php" method="post">
        <label for="book_title">Titel:</label>
        <input type="text" name="book_title" required><br>
        <label for="book_category">Kategorie:</label>
        <input type="text" name="book_category" required><br>
        <label for="book_release">Erscheinungsjahr:</label>
        <input type="text" name="book_release" required><br>
        <label for="book_ISBN">ISBN</label>
        <input type="text" name="book_ISBN" required><br>
        <label for="book_verlag">Verlag</label>
        <input type="text" name="book_verlag" required><br>
        <!-- Weitere Buchinformationen können hinzugefügt werden -->
        <input type="submit" value="Buch hinzufügen">
    </form>
</body>
</html>