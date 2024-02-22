<?php
session_start();
include('../mysql.php');

// Überprüfen, ob der Benutzer angemeldet ist.
if (!isset($_SESSION["username"])) {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $vorname = $_POST["vorname"];
    $geburtstag = $_POST["geburtstag"];
    $telefon = $_POST["telefon"];
    $email = $_POST["email"];
    $passwort = $_POST["passwort"];
    $wohnort = $_POST["wohnort"];




    // User zur Datenbank hinzufügen mit den POST daten der add_user.php.
    $sql = "INSERT INTO kunde (name, vorname, geburtsdatum, telefon, email, passwort, ort_ID) VALUES ('$name', '$vorname', '$geburtstag', '$telefon', '$email', '$passwort', '$wohnort')";

    if ($conn->query($sql) === TRUE) {
        echo "Der Benutzer '$email' wurde erfolgreich hinzugefügt.";
    } else {
        echo "Fehler beim Hinzufügen des Benutzers: " . $conn->error;
    }
}

$conn->close();
?>