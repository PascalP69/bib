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
            <h1>RESETTED</h1>

            <?php

            // Annahme: Du hast eine Tabelle namens 'benutzer' in deiner Datenbank
            $update_avail = "UPDATE exemplar SET verfügbarkeit = 1 WHERE verfügbarkeit = 0";
            $update_transactions = "DELETE from verleihvorgang";

            $conn->query($update_avail);
            $result = $conn->query($update_avail);
            $conn->query($update_transactions);
            $result = $conn->query($update_transactions);

            ?>
        </div>

    </div>

</body>

</html>