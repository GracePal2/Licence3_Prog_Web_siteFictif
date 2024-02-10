<?php
session_start();

$montant_total = 0;

if (isset($_SESSION['client'])) {
    // Utilisateur connecté
    if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
        echo "<h2>Votre Panier :</h2>";
        echo "<table>";
        echo "<tr><th>ID Article</th><th>Nom</th><th>Prix unitaire</th><th>Quantité</th><th>Prix total</th></tr>";

        include("bd.php");
        $bdd = getBD();

        // Remplacez ce bloc par une boucle pour parcourir les articles du panier
        foreach ($_SESSION['panier'] as $id_article => $quantite) {
            $id_article = $id_article;
            $quantite = $quantite;

            $requete = "SELECT id_art, nom, prix FROM articles WHERE id_art = $id_article";
            $rep = $bdd->query($requete);

            if ($rep->rowCount() > 0) {
                $ligne = $rep->fetch();
                $id_art = $ligne['id_art'];
                $nom = $ligne['nom'];
                $prix_unitaire = $ligne['prix']; // Prix unitaire de l'article
                $prix_total = $prix_unitaire * $quantite;

                // Affichez les détails de l'article
                echo "<tr>";
                echo "<td>$id_art</td>";
                echo "<td>$nom</td>";
                echo "<td>$prix_unitaire €</td>";
                echo "<td>$quantite</td>";
                echo "<td>$prix_total €</td>";
                echo "</tr>";
                $montant_total += $prix_total;
            }
        }

        echo "<tr><th colspan='4'>Montant total :</th><td> $montant_total €</td></tr>";
        echo "</table>";
        echo "<a href='commande.php'>Commander</a></br>";
		#var_dump($_SESSION['panier']);
    } else {
        // Panier vide
        echo "Votre panier ne contient aucun article.";
    }

    echo "<a href='index.php'>Retour</a>"; // Lien de retour vers index.php
}
?>
