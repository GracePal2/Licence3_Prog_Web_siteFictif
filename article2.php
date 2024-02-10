<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fraise</title>
    <link rel="stylesheet" href="/Palenfo/styles/index.css" type="text/css" />
</head>
<body>
    <header>
        <h1>La Fraise</h1>
    </header>

    <main>
        <h2>Informations sur le produit</h2>
        <?php
		include("/Palenfo/bd.php"); /

		
		if (isset($_GET["id_art"])) {
			$id_art = $_GET["id_art"];

			
			$bdd = getBD();

			// Requête pour obtenir les informations de l'article
			$query = "SELECT * FROM Articles WHERE id_art = $id_art";
			$result = $bdd->query($query);

			if ($result && $result->num_rows > 0) {
				$article = $result->fetch_assoc();
				// Ici, vous pouvez afficher les informations de l'article
				echo "<h1>" . $article["nom"] . "</h1>";
				echo "<p>Quantité : " . $article["quantite"] . "</p>";
				echo "<p>Prix : " . $article["prix"] . "</p>";
				echo "<a href="/Palenfo/index.php">Retour à la page d'accueil</a>";
				// ...

				$result->close();
			} else {
				echo "L'article n'existe pas.";
			}

			$bdd->close();
		} else {
			echo "Identifiant de l'article manquant.";
		}
		?>
		
        
    </main>

    <footer>
        <p>&copy; 2023 Fruit's Paradise</p>
    </footer>
</body>
</html>
