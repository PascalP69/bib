<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/uikit.min.css" />
    <script src="js/uikit.min.js"></script>
    <script src="js/uikit-icons.min.js"></script>
    <title>Bibliothek - Exemplare hinzufügen</title>
</head>

<body>
    <?php
    session_start();
    include('mysql.php');

    // Überprüfen, ob der Benutzer angemeldet ist und ein spezieller Benutzer ist (z. B. Admin). um nur diesem user zu erlauben die seite aufzurufen
    if (!isset($_SESSION["username"]) || $_SESSION["username"] != "admin@bib.de") {
        header("Location: add_copies.php");
        exit();
    }

    // Datenbankabfrage für Buch Titel und ID
    $query = "SELECT buchtitel, buch_ID FROM buch";
    $result = mysqli_query($conn, $query);
    $buch = mysqli_fetch_all($result, MYSQLI_ASSOC);

    include('templates/nav.php');
    ?>
    <div class="uk-container uk-flex uk-flex-center uk-margin-top">
        <form class="uk-card uk-card-default uk-card-body uk-width-1-2@m" action="processing/process_copies.php" method="post">

            <div class="uk-margin">
                <label class="uk-form-label" for="book_title">Buch:</label>
                <select class="uk-select" name="book_title" required>
                    <!-- Da wir exemplare für vorhandene Bücher hinzufügen wollen, füllen wir hier ein dropdown mit den Büchern aus der Datenbank. -->
                    <?php
                    foreach ($buch as $buch) {
                        echo "<option value='{$buch['buch_ID']}'>{$buch['buchtitel']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="book_condition">Zustand:</label>
                <input class="uk-input" type="text" name="book_condition" required>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="book_amount">Menge:</label>
                <input class="uk-input" type="text" name="book_amount" required>
            </div>

            <div class="uk-margin">
                <input class="uk-button uk-button-primary" type="submit" value="Exemplare hinzufügen">
            </div>
        </form>
    </div>
</body>

</html>