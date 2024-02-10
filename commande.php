<!DOCTYPE html >
<html>
	<head>
		<title>Commande</title>
	</head>
	<body>
<?php
session_start();

if (!isset($_SESSION['csrf_tokens'])) {
    $_SESSION['csrf_tokens'] = [];
}

echo 'Récapitulatif de votre commande:' . "<br />";
$total_commande = 0;

echo '<table>';
echo '<tr><th>ID</th><th>Nom</th><th>Prix</th><th>Quantité</th><th>Prix total</th></tr>';

require("bd.php");
$bdd = getBD();

foreach ($_SESSION['panier'] as $id_article => $quantite) {
    $id_article = $id_article;
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

        echo '<tr>';
        echo '<td>' . $id_art . '</td>';
        echo '<td>' . $nom . '</td>';
        echo '<td>' . $prix_unitaire . '</td>';
        echo '<td>' . $quantite . '</td>';
        echo '<td>' . $prix_total . '</td>';
        echo '</tr>' . "<br />" . "<br />";

        $total_commande += $prix_total;
    }
}

function generateCSRFToken($formName) {
    if (empty($_SESSION['csrf_tokens'][$formName])) {
        $_SESSION['csrf_tokens'][$formName] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_tokens'][$formName];
}

echo '</table>';
echo '<p>Montant de votre commande : ' . $total_commande . '</p>';
echo "La commande sera expédiée à l'adresse suivante:" . '<br />' . '<br />';
echo ' ' . $_SESSION['client']['prenom'] . " " . $_SESSION['client']['nom'] . "<br />";
echo ' ' . $_SESSION['client']['adresse'] . '<br />' . '<br />';
#var_dump($_SESSION['client']);
#var_dump($_SESSION['panier']);

// Récupérer l'ID Stripe de l'utilisateur connecté depuis la session
$id_stripe_utilisateur = isset($_SESSION['client']['id_stripe']) ? $_SESSION['client']['id_stripe'] : '';
// Intégrer le code Stripe pour créer la session de paiement
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once('vendor/autoload.php');
    require_once('stripe.php');

    // Construire le tableau de produits à acheter
    $items = [];
    foreach ($_SESSION['panier'] as $id => $quantite) {
        $items[] = [
            'price' =>$id_stripe_prix,
            'quantity' => $quantite,
        ];
    }

    // Créer la session de paiement avec Stripe
    $checkout_session = $stripe->checkout->sessions->create([
        'customer' => $id_stripe_utilisateur,
        'success_url' => 'http://localhost/Palenfo/acheter.php',
        'cancel_url' => 'http://localhost/Palenfo/commande.php',
        'mode' => 'payment',
        'automatic_tax' => ['enabled' => false],
        'items' => $items,
    ]);

    // Rediriger l'utilisateur vers la page de paiement de Stripe
    ob_end_flush();
    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url);
    exit;
}

// Générer le formulaire
echo '<form action="http://localhost/Palenfo/stripe1.php" method="POST" autocomplete="on">';
echo '<input type="hidden" name="csrf_token" value="' . generateCSRFToken("commande") . '">';
echo '<input type="submit" value="Valider et Payer">' . "<br />";
echo '</form>';
