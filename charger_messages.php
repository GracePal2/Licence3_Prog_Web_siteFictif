<?php
require("bd.php");
$bdd = getBD();

// Vérifiez la connexion


// Récupérez les messages depuis la base de données
$sql =  "SELECT * FROM messages WHERE timestamp > DATE_SUB(NOW(), INTERVAL 10 MINUTE) ORDER BY timestamp ";

$result = $bdd->query($sql);

$messages = array();

if ($result) {
    // Utilisez la méthode fetchAll pour récupérer toutes les lignes
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        $messages[] = array(
            'id' => $row['id'],
            'username' => $row['sender_name'],
            'text' => $row['content'],
            'timestamp' => $row['timestamp']
        );
    }
} else {
    // Gestion des erreurs lors de l'exécution de la requête
    echo "Erreur d'exécution de la requête SQL : " . implode(", ", $bdd->errorInfo());
}
foreach ($messages as $message) {
    $username = $message['username'];
    $text = $message['text'];
    $formatted_message = "$username a dit : \"$text\"";
    echo $formatted_message . "<br>";
}
?>