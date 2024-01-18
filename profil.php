<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzerprofil</title>
    <link rel="stylesheet" href="css/uikit.min.css" />
    <script src="js/uikit.min.js"></script>
    <script src="js/uikit-icons.min.js"></script>
</head>

<body>

    <div class="uk-container uk-margin-large-left uk-margin-large-right uk-margin-large-top">
        <h1>Benutzerprofil</h1>

        <?php
        session_start();
        include('mysql.php');

        // Überprüfen, ob der Benutzer angemeldet ist.
        if (!isset($_SESSION["username"])) {
            header("Location: index.html");
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