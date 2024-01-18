<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKR Bibliothek</title>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="css/uikit.min.css" />

    <!-- Optional: Theme CSS -->
    <link rel="stylesheet" href="css/uikit-rtl.min.css" />

    <!-- UIkit JS -->
    <script src="js/uikit.min.js"></script>
    <script src="js/uikit-icons.min.js"></script>
</head>

<body>
<div class="uk-container">
    <header class="uk-background-primary uk-light uk-padding">
        <h1 class="uk-heading-medium">BKR Bibliothek</h1>
    </header>

    <nav class="uk-navbar-container uk-background-secondary" uk-navbar>
    <div class="uk-navbar-left">
    <ul class="uk-navbar-nav">
    <li><a href="#" onclick="loadContent('books.php')">Bücher</a></li>

        <?php
        // Prüfen, ob der Benutzer eingeloggt ist
        session_start();
        if (isset($_SESSION["username"]) && $_SESSION["username"] == "admin@bib.de") {
            echo '<li><a href="#" onclick="loadContent(\'add_book.php\')">Buch Hinzufügen</a></li>';
        }
        ?>
        <li><a href="#" onclick="loadContent('profil.php')">Profil</a></li>
    </ul>
    </div>
    <div class="uk-navbar-right">
            <?php
            // Beispiel für den eingeloggten Benutzernamen und Logout-Link
            if (isset($_SESSION["username"])) {
                echo '<div class="uk-navbar-item">Willkommen, ' . $_SESSION["username"] . '!</div>';
                echo '<div class="uk-navbar-item"><a href="logout.php" class="uk-button uk-button-danger">Logout</a></div>';
            }
            ?>
        </div>
    </nav>

    <main id="main-content" class="uk-margin-top uk-grid uk-grid-stack">
    <div class="uk-width-1-1">
            <p>Willkommen auf meiner Webseite!</p>
        </div>
    </main>
    </div>
    <script>
        function loadContent(page) {
            // Hier könntest du AJAX verwenden, um den Inhalt der Seite asynchron zu laden
            // Für dieses Beispiel verwende ich einfach die Methode "fetch"
            fetch(page)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('main-content').innerHTML = html;
                })
                .catch(error => console.error('Fehler beim Laden der Seite:', error));
        }
    </script>

</body>

</html>