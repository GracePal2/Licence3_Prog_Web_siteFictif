<!DOCTYPE html >
<html>
	<head>
	    <link rel="stylesheet" href="/Palenfo/styles/index.css" type="text/css"/>

		<title>Historique</title>
	</head>
	<body>
<?php
session_start();
require("bd.php");
$bdd = getBD();

if (isset($_SESSION['client'])) {
    // Récupérez les commandes du client connecté depuis la table Commandes
    $id_client = $_SESSION['client']['id_client'];

    $requete_commandes = "SELECT C.id_commande, C.id_art, articles.nom,clients.id_client ,articles.prix, C.quantite, C.envoi 
	FROM commandes C, articles,clients WHERE C.id_art=articles.id_art AND clients.id_client=$id_client;";
	
    $requete = $bdd->query($requete_commandes);

    // Affichez les commandes dans un tableau
    echo "<table border='1'>
            <tr>
                <th>ID Commande</th>
                <th>ID Article</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>État</th>
            </tr>";

    while ($ligne = $requete ->fetch()) {
		$prix_tot=$ligne['quantite']*$ligne['prix'];
        echo "<tr>";
        echo "<td>" . $ligne['id_commande'] . "</td>";
        echo "<td>" . $ligne['id_art'] . "</td>";
        echo "<td>" . $ligne['nom'] . "</td>";
        echo "<td>" . $prix_tot . "</td>";
        echo "<td>" . $ligne['quantite'] . "</td>";
        echo "<td>" . ($ligne['envoi'] ? "Envoyée" : "Non envoyée") . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}



?>

</body>
 <a href="index.php">Retour</a>

</html>