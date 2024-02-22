<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/uikit.min.css" />
    <script src="js/uikit.min.js"></script>
    <script src="js/uikit-icons.min.js"></script>
    <title>Bibliothek - Benutzer Hinzufügen</title>
</head>

<body>
    <?php
    session_start();
    include('mysql.php');

    // Überprüfen, ob der Benutzer angemeldet ist und ein spezieller Benutzer ist (z. B. Admin). um nur diesem user zu erlauben die seite aufzurufen
    if (!isset($_SESSION["username"]) || $_SESSION["username"] != "admin@bib.de") {
        header("Location: add_user.php");
        exit();
    }

    // Datenbankabfrage für Wohnorte
    $query = "SELECT name, plz, ort_ID FROM ort";
    $result = mysqli_query($conn, $query);
    $ort = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Einbinden des headers und der navigation
    include('templates/nav.php');
    ?>

    <div class="uk-container uk-margin-left uk-margin-right uk-margin-large-top uk-width-1-1">
        <div class="uk-container uk-flex uk-flex-center">
            <form class="uk-card uk-card-default uk-card-body uk-width-1-2@m" action="processing/process_user.php"
                method="post">
                <!-- Forms für benutzerdaten -->
                <div class="uk-margin">
                    <label class="uk-form-label" for="name">Name:</label>
                    <input class="uk-input" type="text" name="name" required>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="vorname">Vorname:</label>
                    <input class="uk-input" type="text" name="vorname" required>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="geburtstag">Geburtsdatum:</label>
                    <input class="uk-input" type="text" name="geburtstag" required>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="telefon">Telefonnummer:</label>
                    <input class="uk-input" type="text" name="telefon" required>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="email">E-Mail:</label>
                    <input class="uk-input" type="text" name="email" required>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="passwort">Passwort:</label>
                    <input class="uk-input" type="text" name="passwort" required>
                </div>
                <!-- Verfügbare wohnorte holen und in dropdown anzeigen -->
                <div class="uk-margin">
                    <label class="uk-form-label" for="wohnort">Wohnort:</label>
                    <select class="uk-select" name="wohnort" required>
                        <?php
                        // Wichtig: die VALUE ist die ID die auch übergeben werden kann und gleichzeitig die sortierung des dropdowns; alles dahinter das was angezeigt wird als text.
                        foreach ($ort as $ort) {
                            echo "<option value='{$ort['ort_ID']}'>{$ort['plz']} {$ort['name']}</option>";
                        }
                        ?>
                    </select>
                </div>


                <!-- Benutzer Hinzufügen submit -->
                <div class="uk-margin">
                    <input class="uk-button uk-button-primary" type="submit" value="Benutzer hinzufügen">
                </div>
            </form>
        </div>
</body>

</html>