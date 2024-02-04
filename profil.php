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
        
    <div class="uk-grid-divider uk-child-width-expand@s" uk-grid>
        <div>
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
        <div>
        <div class="uk-grid uk-child-width-1-1">
            <div>

                <h2>Aktive Leihen</h2>
                <table class="uk-table uk-table-striped uk-table-hover">
                    <thead>
                        <tr>
                            <th style="text-align: center">Ausleihdatum</th>
                            <th style="text-align: center">Rückgabestatus</th>
                            <th style="text-align: center">Preis</th>
                            <th style="text-align: center">Zahlungsstatus</th>
                            <th style="text-align: center">Exemplar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $username = $_SESSION["username"];
                        $sql_leihen = "SELECT * FROM kunde, verleihvorgang WHERE kunde.email = '$username' and kunde.kunde_ID = verleihvorgang.kunden_ID";
                        $result_leihen = $conn->query($sql_leihen);

                        if ($result_leihen->num_rows > 0) {
                            while ($row_leihen = $result_leihen->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td style="text-align: center">' . $row_leihen["ausleihdatum"] . '</td>';
                                echo '<td style="text-align: center">' . $row_leihen["rückgabestatus"] . '</td>';
                                echo '<td style="text-align: center">' . $row_leihen["preis"] . '€</td>';
                                echo '<td style="text-align: center">' . $row_leihen["zahlungsstatus"] . '</td>';
                                echo '<td style="text-align: center">' . $row_leihen["exemplar_ID"] . '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="7">Keine Daten gefunden.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>


</body>

</html>