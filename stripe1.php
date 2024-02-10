<?php
session_start();

require("bd.php");
$bdd = getBD();
require_once('vendor/autoload.php');
require_once('stripe.php');

foreach ($_SESSION['panier'] as $id => $quantite) {
    $id_article = $id;
    $quantite = $quantite;

    $requete = 'select id_art, nom, prix,id_stripe FROM articles WHERE id_art =' . $id_article;
    $resultat = $bdd->query($requete);

    if ($resultat->rowCount() > 0) {
        $row = $resultat->fetch();
        $id_art = $row['id_art'];
        $nom = $row['nom'];
        $prix_unitaire = $row['prix'];
		$id_stripe_prix = $row['id_stripe'];
        $prix_total = $prix_unitaire * $quantite;
		
		$line_items[] = [
            'price' =>$id_stripe_prix,
            'quantity' => $quantite,
        ];
    }
}
	//$id_stripe_utilisateur = isset($_SESSION['client']['id_stripe']) ? $_SESSION['client']['id_stripe'] : '';
    // Créer la session de paiement avec Stripe
    $checkout_session = $stripe->checkout->sessions->create([
        'customer' => $_SESSION['client']['id_stripe'],
        'success_url' => 'http://localhost/Palenfo/acheter.php',
        'cancel_url' => 'http://localhost/Palenfo/commande.php',
        'mode' => 'payment',
		'payment_method_types' => ['card'],
        'automatic_tax' => ['enabled' => false],
        'line_items' => $line_items,
    ]);

    // Rediriger l'utilisateur vers la page de paiement de Stripe
    header("Location: " . $checkout_session->url);
    exit;