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
    session_start();
    include('mysql.php');
    $username = $_SESSION["username"];
    $sql_get = "SELECT status FROM kunde WHERE email = '$username'";
    $result_get = $conn->query($sql_get);
    $result = mysqli_fetch_assoc($result_get);
    $resultstring = $result['status'];

    // Überprüfen, ob der Benutzer angemeldet ist und ein spezieller Benutzer ist (z. B. Admin). um nur diesem user zu erlauben die seite aufzurufen
    if (isset($_SESSION["username"]) && $resultstring == 1) {
        header("Location: add_book.php");
        exit();
    }

    // Datenbankabfrage für Verlage & Kategorien
    $query = "SELECT verlagname, verlag_ID FROM verlag";
    $result = mysqli_query($conn, $query);
    $verlage = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $query = "SELECT kategorie.name, kategorie.kategorie_ID FROM kategorie";
    $result_kat = mysqli_query($conn, $query);
    $kategorien = mysqli_fetch_all($result_kat, MYSQLI_ASSOC);

    // Einbinden der navi
    include('templates/nav.php');
    ?>

    <!-- Bauen des Forms zum hinzufügen eines neuen Buchs -->
    <div class="uk-container uk-flex uk-flex-center uk-margin-top">
        <!-- POST wird an die Seite "processing/process_book.php" geschickt -->
        <form class="uk-card uk-card-default uk-card-body uk-width-1-2@m" action="processing/process_book.php" method="post">
            <div class="uk-margin">
                <!-- Text der angezeigt wird, name und identifier des form objektes -->
                <label class="uk-form-label" for="book_title">Titel:</label>
                <input class="uk-input" type="text" name="book_title" required>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="book_release">Erscheinungsjahr:</label>
                <input class="uk-input" type="text" name="book_release" required>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="book_ISBN">ISBN:</label>
                <input class="uk-input" type="text" name="book_ISBN" required>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="book_preis">Preis:</label>
                <input class="uk-input" type="text" name="book_preis" required>
            </div>

            <div class="uk-margin">
                
                <label class="uk-form-label" for="book_verlag">Verlag:</label>
                <select class="uk-select" name="book_verlag" required>
                    <!-- Dropdown füllen mit dem result der Datenbankabfrage oben -->
                    <?php
                    foreach ($verlage as $verlag) {
                        echo "<option value='{$verlag['verlag_ID']}'>{$verlag['verlagname']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="book_category">Kategorie:</label>
                <select class="uk-select" name="book_category" required>
                    <!-- Dropdown füllen mit dem result der Datenbankabfrage oben -->
                    <?php
                    foreach ($kategorien as $kategorie) {
                        echo "<option value='{$kategorie['kategorie_ID']}'>{$kategorie['name']}</option>";
                    }
                    ?>
                </select>
            </div>
                    <!-- Button um das Buch hinzuzufügen -->
            <div class="uk-margin">
                <input class="uk-button uk-button-primary" type="submit" value="Buch hinzufügen">
            </div>
        </form>
    </div>
</body>

</html>