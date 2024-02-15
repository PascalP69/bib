<nav class="uk-navbar-container uk-background-secondary uk-dark" uk-navbar>
    <div class="uk-navbar-left uk-dark ">
        <ul class="uk-navbar-nav uk-dark">
            <li><a href="books.php">Bücher</a></li>
            <li><a href="reset.php">RESET(DEBUG)</a></li>

            <?php
            // Prüfen, ob der Benutzer eingeloggt ist
            
            if (isset($_SESSION["username"]) && $_SESSION["username"] == "admin@bib.de") {
                echo '<li><a href="add_book.php">Buch Hinzufügen</a></li>';
                echo '<li><a href="add_copies.php">Exemplare Hinzufügen</a></li>';
                echo '<li><a href="resolve_loans.php">Leihen Verarbeiten</a></li>';
            }
            ?>
            <li><a href="profil.php">Profil</a></li>
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