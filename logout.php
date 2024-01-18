<?php
session_start();

// Session löschen (alle gespeicherten Session-Daten werden gelöscht)
session_unset();

// Session zerstören
session_destroy();

// Weiterleitung zur Login-Seite (oder einer anderen gewünschten Seite)
header("Location: index.html");
exit();
?>