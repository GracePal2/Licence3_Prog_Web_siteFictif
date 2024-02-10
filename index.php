<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Palenfo/styles/index.css" type="text/css"/>
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<script src="script.js"></script>
    <title>Fruit's Paradise</title>
	<style>
        #chat-container {
            position: fixed;
            bottom: 0;
            right: 0;
            width: 300px;
            border: 1px solid #ccc;
            background-color: #39aacc;
            padding: 10px;
        }
    </style>
	
</head>
<body>
    <header>
        <h1>Fruit's Paradise</h1>
    </header>
    <main>
        <h2>Nos Produits</h2>
        <?php
        // Vérifiez si une session a été créée (si l'utilisateur est connecté)
        if (isset($_SESSION['client'])) {
            $client = $_SESSION['client'];
            echo "Bonjour {$client['prenom']} {$client['nom']}<br>";
            echo "<a href='deconnexion.php'>Se déconnecter</a></br>";
			echo "<a href='panier.php'>Consulter le Panier</a></br>"; // Lien vers le panier
			echo "<a href='historique.php'><strong>Historique des commandes ></strong></a></br>";
        } else {
            // Si l'utilisateur n'est pas connecté, affichez les liens "Nouveau Client" et "Se connecter"
            echo "<a href='nouveau.php'>Nouveau Client</a><br>";
            echo "<a href='connexion.php'>Se connecter</a>";
        }
		#var_dump($_SESSION['client']);

        ?>
    </main>
		<div id="chat-container">
        <div id="chat-window"></div>
        <input type="text" id="message-input" maxlength="256" placeholder="Tapez votre message...">
        <button onclick="sendMessage()">Envoyer</button>
	</div>

        <?php
			include("bd.php");
			$bdd = getBD();
			echo "<table>";
			echo '<tr>
			<th>id_art</th>
			<th>nom</th>
			<th>quantite</th>
			<th>prix</th>
			<th>url_photo</th>
			<th>description</th>
			</tr>';
			$rep = $bdd->query("SELECT * FROM Articles");
			while ($ligne = $rep->fetch()) {
				echo "<tr>";
				echo "<td>" . $ligne["id_art"] . "</td>\n";
				echo "<td><a href='/Palenfo/articles/article.php?id_art=" . $ligne["id_art"] . "'>" . $ligne["nom"] . "</a></td>";
				echo "<td>" . $ligne["quantite"] . "</td>\n";
				echo "<td>" . $ligne["prix"] . "</td>\n";
				echo '<td><img src="' . $ligne['url_photo'] . '" alt="' . $ligne['nom'] . '" height="100"></td>';
				echo "<td>" . $ligne["description"] . "</td>\n";
				echo "</tr>";
			}
			echo "</table>";
			$rep->closeCursor();
?>

    </main>

    <footer>
        <p>&copy; 2023 Fruit's Paradise</p>
        <a href="/Palenfo/contact/contact.html">Contact</a>
    </footer>
</body>
</html>
