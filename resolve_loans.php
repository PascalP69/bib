<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKR Bibliothek - Ausleihen bearbeiten</title>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="css/uikit.min.css" />

    <!-- Optional: Theme CSS -->
    <link rel="stylesheet" href="css/uikit-rtl.min.css" />

    <!-- UIkit JS -->
    <script src="js/uikit.min.js"></script>
    <script src="js/uikit-icons.min.js"></script>
</head>

<script>
    // Event listener musste benutzt werden weil es wohl timing probleme beim UIKit JS gibt
    document.addEventListener("DOMContentLoaded", function () {
        // Überprüfen, ob das Formular abgeschickt wurde und die Notify-Nachricht anzeigen
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rückgabe_taetigen']) && isset($_POST['form_submitted'])) {
            if (isset($_POST['selected_books_rückgabe'])) {
                echo "UIkit.notification('<span uk-icon=\'icon: check\'></span> Rückgabe erfolgreich!', { status: 'success', timeout: '2000'});";
            } else {
                echo "UIkit.notification('<span uk-icon=\'icon: close\'></span> Keine Bücher ausgewählt!', { status: 'danger', timeout: '2000'});";
            }

        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['zahlung_taetigen']) && isset($_POST['form_submitted'])) {
            if (isset($_POST['selected_books_zahlung'])) {
                echo "UIkit.notification('<span uk-icon=\'icon: check\'></span> Zahlung bestätigt!', { status: 'success', timeout: '2000'});";
            } else {
                echo "UIkit.notification('<span uk-icon=\'icon: close\'></span> Keine Bücher ausgewählt!', { status: 'danger', timeout: '2000'});";
            }

        }
        ?>
    });
</script>

<body>
    <?php
    session_start();
    include('mysql.php');

    $username = $_SESSION["username"];
    $sql_get = "SELECT status FROM kunde WHERE email = '$username'";
    $result_get = $conn->query($sql_get);
    $result_b = mysqli_fetch_assoc($result_get);
    $resultstring = $result_b['status'];

    // Überprüfen, ob der Benutzer angemeldet ist und ein spezieller Benutzer ist (z. B. Admin). um nur diesem user zu erlauben die seite aufzurufen
    if (!isset($_SESSION["username"]) && $resultstring == 1) {
        header("Location: resolve_loans.php");
        exit();
    }
    // Wenn request method = post ist und im post "rückgabe_taetigen" steht (button id), und form submitted ist (security), dann...
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rückgabe_taetigen']) && isset($_POST['form_submitted'])) {
        // wenn im post werte für "selected_books_rückgabe" vorhanden sind, dann..
        if (isset($_POST['selected_books_rückgabe'])) {
            // variable selected_books gesetzt auf den inhalt des posts (mehrere bücher)
            $selected_books = $_POST['selected_books_rückgabe'];

            // Exemplare aus der Datenbank auf 0 setzen um sie nicht verfügbar zu machen, da sie ausgeliehen wurden und den spezifischen Verleihvorgang löschen.
            foreach ($selected_books as $exemplar_id) {
                $update_sql = "UPDATE exemplar SET verfügbarkeit = 1 WHERE exemplar_ID = $exemplar_id";
                $conn->query($update_sql);

                $delete_sql = "DELETE from verleihvorgang WHERE exemplar_ID = $exemplar_id";
                $conn->query($delete_sql);
            }
        }
        // Wenn request method = post ist und im post "zahlung_taetigen" steht (button id), und form submitted ist (security), dann...
    } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['zahlung_taetigen']) && isset($_POST['form_submitted'])) {
        // wenn im post werte für "selected_books_zahlung" vorhanden sind, dann..
        if (isset($_POST['selected_books_zahlung'])) {
            // variable selected_books gesetzt auf den inhalt des posts (mehrere bücher)
            $selected_books_zahlung = $_POST['selected_books_zahlung'];

            // Exemplar im Verleihvorgang auf "bezahlt" setzen
            foreach ($selected_books_zahlung as $exemplar_id) {
                $update_zahlung_sql = "UPDATE verleihvorgang SET zahlungsstatus = 1 WHERE exemplar_ID = $exemplar_id";
                $conn->query($update_zahlung_sql);

            }
        }
    }

    // Einbinden des Headers und der Navigation
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

    // Query zum füllen eines dropdowns mit den Kunden und ihrer Kundennummer
    $query = "SELECT * FROM kunde";
    $result = mysqli_query($conn, $query);
    $kunde = mysqli_fetch_all($result, MYSQLI_ASSOC);

    ?>
    <div class="uk-container uk-flex uk-flex-center uk-margin-top">

        <form action="" method="post">
            <div class="uk-margin">
                <label for="kunde_ID">Kunde auswählen:</label>
                <select class="uk-select" name="kunde_ID" required>

                    <?php
                    foreach ($kunde as $kunde) {
                        echo "<option value='{$kunde['kunde_ID']}'>{$kunde['vorname']} {$kunde['name']} - ID: {$kunde['kunde_ID']} </option>";
                    }
                    ?>
                </select>
            </div>
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

        // Kundendaten seperat anzeigen
        if ($customerData) {
            echo "Kunden-ID: " . $customerData['kunde_ID'] . "<br>";
            echo "Vorname: " . $customerData['vorname'] . "<br>";
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
                                    <th style="text-align: center">Preis</th>
                                    <th style="text-align: center">Zahlungsstatus</th>
                                    <th style="text-align: center">Rückgabe</th>
                                    <th style="text-align: center">Zahlung</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cost = 0;
                                $username = $_SESSION["username"];
                                // Subselect um den Buchtitel anzeigen zu können - chatGPT magic
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
                                // auswerten des results; anzeigen der aktiven leihen
                                if ($result_leihen->num_rows > 0) {
                                    while ($row_leihen = $result_leihen->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td style="text-align: center">' . $row_leihen["buchtitel"] . '</td>';
                                        echo '<td style="text-align: center">' . $row_leihen["ausleihdatum"] . '</td>';
                                        echo '<td style="text-align: center">' . $row_leihen["preis"] . '€</td>';
                                        // Wenn zahlungsstatus = 0 dann die rückgabe checkbox deaktivieren und die bezahlen checkbox aktivieren
                                        if ($row_leihen["zahlungsstatus"] == 0) {
                                            $cost = (int) $cost + (int) $row_leihen["preis"];
                                            echo '<td style="text-align: center"><span uk-icon="icon: close; ratio: 1" style="color:red"></span></td>';
                                            echo '<td style="text-align: center"><input class="uk-checkbox" disabled  type="checkbox" name="selected_books_rückgabe[]" value="' . $row_leihen["exemplar_ID"] . '"></td>';
                                            echo '<td style="text-align: center"><input class="uk-checkbox"   type="checkbox" name="selected_books_zahlung[]" value="' . $row_leihen["exemplar_ID"] . '"></td>';
                                            // wenn zahlungsstatus = 1 dann rückgabe checkbox aktivieren und bezahlen deaktivieren
                                        } else {
                                            echo '<td style="text-align: center"><span uk-icon="icon: check; ratio: 1" style="color:green"></span></td>';
                                            echo '<td style="text-align: center"><input class="uk-checkbox"  type="checkbox" name="selected_books_rückgabe[]" value="' . $row_leihen["exemplar_ID"] . '"></td>';
                                            echo '<td style="text-align: center"><input class="uk-checkbox"  disabled type="checkbox" name="selected_books_zahlung[]" value="' . $row_leihen["exemplar_ID"] . '"></td>';
                                        }
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="7">Keine Daten gefunden.</td></tr>';
                                }
                                ?>
                            </tbody>
                            <?php
                            if ($cost == 0) {
                                echo '<span uk-icon="icon: cart; ratio: 2" style="color:green"></span>';

                            } else {
                                echo '<span uk-icon="icon: cart; ratio: 2" style="color:red"></span>';
                            }
                            print("  Zahlung offen:  ");
                            print($cost);
                            print("€");
                            ?>
                        </table>
                    </div>

                </div>

                <button class="uk-button uk-button-primary" type="submit" name="rückgabe_taetigen">Buch
                    Zurückführen</button>

                <button class="uk-button uk-button-primary" type="submit" name="zahlung_taetigen">Buch
                    Bezahlen</button>

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