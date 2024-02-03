<?php
        session_start();
        include('mysql.php');

?>
<!DOCTYPE html>
<html lang="en">

<?php
        include('templates/head.php');
?>

<body>
    <?php
    include('templates/header.php');
    include('templates/nav.php');
    ?>
    <div class="uk-container uk-margin-large-left uk-margin-large-right uk-margin-large-top">
        <h1>Benutzerprofil</h1>

        <?php

        // Überprüfen, ob der Benutzer angemeldet ist.
        if (!isset($_SESSION["username"])) {
            header("Location: profil.php");
            exit();
        }

        // Annahme: Du hast eine Tabelle namens 'benutzer' in deiner Datenbank
        $username = $_SESSION["username"];
        $sql = "SELECT * FROM kunde WHERE email = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo '<h2>Benutzerinformationen</h2>';
            echo '<p><strong>Kundennummer:</strong> ' . $row["kunde_ID"] . '</p>';
            echo '<p><strong>Benutzername:</strong> ' . $row["name"] . '</p>';
            echo '<p><strong>Vorname:</strong> ' . $row["vorname"] . '</p>';
            echo '<p><strong>Nachname:</strong> ' . $row["geburtsdatum"] . '</p>';
            echo '<p><strong>Telefon::</strong> ' . $row["telefon"] . '</p>';
            echo '<p><strong>Email:</strong> ' . $row["email"] . '</p>';
            // Weitere Informationen je nach Bedarf ausgeben
        } else {
            echo "Benutzerprofil nicht gefunden.";
        }
        ?>

    </div>

</body>

</html>