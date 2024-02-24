<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname = 'bkrbibb_pazek_pascal';

$conn = new mysqli($hostname, $username, $password, $dbname);

// Überprüfen, ob die Verbindung erfolgreich war
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}