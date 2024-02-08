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

<body class="uk-background-muted">
    <?php
    session_start();
    include('mysql.php');

    // Überprüfen, ob der Benutzer angemeldet ist und ein spezieller Benutzer ist (z. B. Admin).
    if (!isset($_SESSION["username"]) || $_SESSION["username"] != "admin@bib.de") {
        header("Location: resolve_loans.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rückgabe_taetigen']) && isset($_POST['form_submitted'])) {
        if (isset($_POST['selected_books'])) {
            $selected_books = $_POST['selected_books'];
    
            //Holen des eingeloggten Usernamen und das Extrahieren der KundenID durch SQL Abfrage
            $username = $_SESSION["username"];
            $sql_get = "SELECT * FROM kunde WHERE email = '$username'";
            $result_get = $conn->query($sql_get);
             
            // Exemplare aus der Datenbank auf 0 setzen um sie nicht verfügbar zu machen, da sie ausgeliehen wurden.
            foreach ($selected_books as $exemplar_id) {
                $update_sql = "UPDATE exemplar SET verfügbarkeit = 1 WHERE exemplar_ID = $exemplar_id";
                $conn->query($update_sql);

                $delete_sql = "DELETE from verleihvorgang WHERE exemplar_ID = $exemplar_id";
                $conn->query($delete_sql);
            }
        }
    }





    // Funktion zur Abfrage von Kundendaten basierend auf Kunden-ID
    
    include('templates/header.php');

    include('templates/nav.php');
    function getCustomerData($customerId)
    {
        global $conn;

        $query = "SELECT * FROM kunde WHERE kunde_ID = $customerId";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }


    $query = "SELECT * FROM kunde";
    $result = mysqli_query($conn, $query);
    $kunde = mysqli_fetch_all($result, MYSQLI_ASSOC);

    ?>
    <div class="uk-container uk-flex uk-flex-center uk-margin-top">

        <form action="" method="post">
            <div class="uk-margin">
                <label for="kunde_ID">Kunden-ID auswählen:</label>
                <select class="uk-select" name="kunde_ID" required>

                    <?php
                    foreach ($kunde as $kunde) {
                        echo "<option value='{$kunde['kunde_ID']}'>{$kunde['name']}</option>";
                    }
                    ?>
                </select>
            </div>


            <!-- Weitere Kundendaten können hier dynamisch hinzugefügt werden -->
            </select>
            <button class="uk-button uk-button-primary" type="submit" name="Kundeninformationen_anzeigen">Kunde
                Anzeigen</button>
        </form>
    </div>
    <?php
    // Überprüfen, ob das Formular abgeschickt wurde
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Kundeninformationen_anzeigen']) && !isset($_POST['form_submitted'])) {
        // Kunden-ID aus dem Formular erhalten
        $selectedCustomerId = $_POST['kunde_ID'];

        // Kundendaten abrufen
        $customerData = getCustomerData($selectedCustomerId);

        // Kundendaten anzeigen
        if ($customerData) {
            echo "Kunden-ID: " . $customerData['kunde_ID'] . "<br>";
            echo "Name: " . $customerData['name'] . "<br>";

            ?>
            <form method="post" action="">
                <div class="uk-card uk-card-default uk-card-body uk-width-1-2">

                    <div>

                        <h2>Aktive Leihen</h2>
                        <table class="uk-table uk-table-striped uk-table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Buchtitel</th>
                                    <th style="text-align: center">Ausleihdatum</th>
                                    <th style="text-align: center">Rückgabestatus</th>
                                    <th style="text-align: center">Preis</th>
                                    <th style="text-align: center">Zahlungsstatus</th>
                                    <th style="text-align: center">Exemplar</th>
                                    <th style="text-align: center">Rückgabe?</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $username = $_SESSION["username"];
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
                                                kunde.kunde_ID = '$selectedCustomerId'";
                                $result_leihen = $conn->query($sql_leihen);

                                if ($result_leihen->num_rows > 0) {
                                    while ($row_leihen = $result_leihen->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td style="text-align: center">' . $row_leihen["buchtitel"] . '</td>';
                                        echo '<td style="text-align: center">' . $row_leihen["ausleihdatum"] . '</td>';
                                        echo '<td style="text-align: center">' . $row_leihen["rückgabestatus"] . '</td>';
                                        echo '<td style="text-align: center">' . $row_leihen["preis"] . '€</td>';
                                        echo '<td style="text-align: center">' . $row_leihen["zahlungsstatus"] . '</td>';
                                        echo '<td style="text-align: center">' . $row_leihen["exemplar_ID"] . '</td>';
                                        echo '<td style="text-align: center"><input class="uk-checkbox" type="checkbox" name="selected_books[]" value="' . $row_leihen["exemplar_ID"] . '"></td>';
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
                <div class="uk-flex uk-flex-left">
                    <button class="uk-button uk-button-primary" type="submit" name="rückgabe_taetigen">Buch
                        Zurückführen</button>
                </div>
                <input type="hidden" name="form_submitted" value="1">
            </form>
            <?php
        } else {
            echo "Kunde nicht gefunden.";
        }
    }

    ?>



</body>

</html>