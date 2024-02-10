<?php 
	session_start();
	
// Vérifier si l'id_art a été passé en paramètre
	if (isset($_GET['id_art'])) {
			$id_art = $_GET['id_art'];
		
		require "../bd.php";
		$bdd= getBD();

		// Sélectionner l'article correspondant à l'id_art
		$query = "SELECT id_art,nom,quantite,prix,url_photo,description FROM Articles WHERE id_art = :id_art";
		$stmt = $bdd->prepare($query);
		$stmt->bindParam(':id_art', $id_art, PDO::PARAM_INT);
		$stmt->execute();

		// Récupérer les données de l'article
		$article = $stmt->fetch(PDO::FETCH_ASSOC);
		$art_id= $article['id_art'];
	} else {
		// Rediriger si l'id_art n'est pas défini
		header('Location: ../index.php');
		exit();
	}

	$stmt -> closeCursor();
?>

<!doctype html>
<html>
	<head>
		<link rel="stylesheet" href="../styles/index.css" type="text/css" />
		<meta charset="UTF-8">
		<title>Articles</title>
		
	</head>
	
	<body>
		<main>
			<h2><?php echo $article['nom']; ?></h2>
			<img src="<?php echo $article['url_photo']; ?>" alt="<?php echo $article['nom']; ?>">

			<p>Description : <?php echo $article['description']; ?></p>
			<div>Quantité en stock : <?php echo $article['quantite']; ?></div>
			<p>Prix : <?php echo $article['prix']; ?> €</p>
			
		</main>
		<?php
			
		if (isset($_SESSION['client'])){
		?>
					
		<form action="ajouter.php" method="post" autocomplete="on">
			<p>
				<input class="form-control" type="hidden" name="id" value="<?php echo $art_id;?>"/>
			</p>
			
			<p>
				Entrez le nombres de <?= $article['nom'] ?> que vous souhaitez commandez:
				<input class="form-control" type="number" name="quantite" value=""/>
			
				<input type="submit" value="Ajouter à votre panier">
			</p>
			
		</form>
				
			<?php  
			} else{
				echo 'Veuillez vous connecter pour ajouter des articles dans votre panier.';
			} 
				
			?>
			
	
	
		<footer>
			<a href="../index.php" class="btn"><strong>Retour </strong></a>
			
		</footer>
	</body>
</html>
