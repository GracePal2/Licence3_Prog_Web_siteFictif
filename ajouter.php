<?php
	session_start();
	
	//verifions si les champs sont vides et sinon on crée la variable $_SESSION['panier']
	if (empty($_POST['quantite'])){
		header('Location: articles/article.php');
		exit;
	}
	else{

		// Vérifier si la variable de session 'panier' existe
		if (!isset($_SESSION['panier'])) {
			// Si le panier n'existe pas encore, initialiser un tableau vide
			$_SESSION['panier'] = array();
		}

	
		if(  $_SESSION['panier'][$_POST["id"]] ){}
		else{ $_SESSION['panier'][$_POST["id"]] = 0;}
			
		$_SESSION['panier'][$_POST["id"]] += $_POST['quantite'];
		

		// Rediriger vers la page index.php
		header('Location: ../index.php');
		exit;
	}
?>
