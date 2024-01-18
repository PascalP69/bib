<?php
session_start();
include('mysql.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM kunde WHERE email='$username' AND passwort='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION["username"] = $username;
        header("Location: home.php");
        exit();
    } else {
        echo "Falscher Benutzername oder Passwort.";
    }
}
$conn->close();
?>