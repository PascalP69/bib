<header class="uk-sticky uk-background-primary uk-light uk-padding">
        <h1 class="uk-sticky uk-heading-medium">BKR Bibliothek</h1>
</header>
<nav class="uk-sticky uk-navbar-container uk-background-secondary uk-dark" uk-navbar>
    <div class="uk-sticky uk-navbar-left uk-dark ">
        <ul class="uk-sticky uk-navbar-nav uk-dark">
            <li><a href="books.php">Bücher Leihen</a></li>
            <li><a href="reset.php">RESET(DEBUG)</a></li>

            <?php
            include('mysql.php');

            // Holen des status wertes des eingeloggten nutzers um damit zu erlauben, dass ein mitarbeiter mit status "1" admin rechte bekommt, normale user mit "0" jedoch nicht.
            $username = $_SESSION["username"];
            $sql_get = "SELECT status FROM kunde WHERE email = '$username'";
            $result_get = $conn->query($sql_get);
            $result = mysqli_fetch_assoc($result_get);
            $resultstring = $result['status'];
            //print($resultstring);


            // Prüfen, ob der Benutzer eingeloggt ist
            // Abgleichen ob der vorher geholte resultstring eine 1 oder eine 0 ist. Wenn 1, dann füge die navigations felder hinzu.
            if (isset($_SESSION["username"]) && $resultstring == 1) {
                echo '<li><a href="add_user.php">Benutzer Hinzufügen</a></li>';
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