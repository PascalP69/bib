<?php
session_start();
include('mysql.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKR Bibliothek - Profil</title>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="css/uikit.min.css" />

    <!-- Optional: Theme CSS -->
    <link rel="stylesheet" href="css/uikit-rtl.min.css" />

    <!-- UIkit JS -->
    <script src="js/uikit.min.js"></script>
    <script src="js/uikit-icons.min.js"></script>
</head>

<body>
    <?php
    include('templates/nav.php');
    ?>
    <div class="uk-container uk-margin-left uk-margin-right uk-margin-large-top uk-width-1-1">
        <div class="uk-child-width-1-1@s uk-child-width-1-3@m uk-width-1-1" uk-grid>
            <div class="uk-card uk-card-default uk-card-body">
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
            <div class="uk-card uk-card-default uk-card-body uk-width-1-2">
                <div>
                    <h2>Aktive Leihen</h2>
                    <table class="uk-table uk-table-striped uk-table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center">Buchtitel</th>
                                <th style="text-align: center">Ausleihdatum</th>
                                <th style="text-align: center">Preis</th>
                                <th style="text-align: center">Zahlungsstatus</th>
                                <th style="text-align: center">Exemplar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $username = $_SESSION["username"];
                            $cost = 0;
                            $sql_leihen = "SELECT 
                                                (SELECT buchtitel 
                                                FROM buch 
                                                WHERE buch.buch_ID = exemplar.buch_id) AS buchtitel,
                                                    ausleihdatum, 
                                                    rückgabestatus, 
                                                    preis, 
                                                    zahlungsstatus, 
                                                    verleihvorgang.exemplar_ID 
                                                FROM 
                                                    exemplar 
                                                    INNER JOIN verleihvorgang ON exemplar.exemplar_ID = verleihvorgang.exemplar_ID 
                                                    INNER JOIN kunde ON kunde.kunde_ID = verleihvorgang.kunden_ID 
                                                WHERE 
                                                    kunde.email = '$username'";
                            $result_leihen = $conn->query($sql_leihen);

                            if ($result_leihen->num_rows > 0) {
                                while ($row_leihen = $result_leihen->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td style="text-align: center">' . $row_leihen["buchtitel"] . '</td>';
                                    echo '<td style="text-align: center">' . $row_leihen["ausleihdatum"] . '</td>';
                                    echo '<td style="text-align: center">' . $row_leihen["preis"] . '€</td>';

                                    // Wenn der Zahlungsstatus 0 ist, zeige ein X icon, wenn er 1 ist, dann ein Checkmark.
                                    if ($row_leihen["zahlungsstatus"] == 0) {
                                        $cost = (int) $cost + (int) $row_leihen["preis"];
                                        echo '<td style="text-align: center"><span uk-icon="close" style="color:red"></span></a></td>';
                                    } else {
                                        echo '<td style="text-align: center"><span uk-icon="check" style="color:green"></span></a></td>';
                                    }
                                    echo '<td style="text-align: center">' . $row_leihen["exemplar_ID"] . '</td>';
                                    echo '</tr>';
                                }

                            } else {
                                echo '<tr><td colspan="7">Keine Daten gefunden.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <span uk-icon="icon: cart; ratio: 2" style="color:red"></span>
                    <?php print("  Zahlung offen:  ");
                    print($cost);
                    print("€"); ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>