<?php
// Connectez-vous à votre base de données (à adapter selon votre configuration)
session_start();
require("bd.php");
$bdd = getBD();

// Vérifiez la connexion
if ($bdd->connect_error) {
    die("La connexion à la base de données a échoué : " . $bdd->connect_error);
}

// Récupérez le message depuis la requête POST
$message = $_POST['message'];
if (isset($_SESSION['client'])) {
    $username = $_SESSION['client']['prenom'];
    $id_client = $_SESSION['client']['id_client'];
} else {
    // Gérez le cas où les informations de session ne sont pas disponibles
    echo "Erreur : Informations de session manquantes.";
    exit();
}
// Insérez le message dans la base de données
$sql = "INSERT INTO messages (sender_name, sender_id, content) VALUES ('$username', '$id_client', '$message')";

if ($bdd->query($sql) === TRUE) {
    echo "Message envoyé avec succès!";
} else {
    echo "Erreur lors de l'envoi du message : " . $bdd->error;
}

$bdd->close();
?>