<?php
session_start();
session_unset(); // Supprime toutes les données de la session
session_destroy(); // Détruit la session

header("Location: index.php");
exit();
?>
