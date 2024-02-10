<!DOCTYPE html >
<html>
	<head>
		<title>Acheter</title>
	</head>
	<body>
<?php 
	session_start();
	
	// Se connecter à la base de données en appelant la fonction getBD()
	require "bd.php";
	$bdd1= getBD();
	$id_client= $_SESSION['client']['id_client'];
		
		//Préparer la requête à executer
	
	$sql= "INSERT INTO commandes(id_art,id_client,quantite,envoi) values (?,?,?,?)";
	$requete = $bdd1->prepare($sql);
	
	foreach($_SESSION['panier'] as $id_article => $quantite){
		$id_art= $id_article;
		$quantite= $quantite;
		$envoi= true;
		
		$requete-> execute([$id_art, $id_client, $quantite, $envoi]);
	}
	foreach($_SESSION['panier'] as $id_article => $quantite){
		$id_art= $id_article;
		$quantite_commandee= $quantite;
		
		$sql_quantite_stock= "SELECT quantite FROM articles WHERE id_art= ?";
		$requete2= $bdd1->prepare($sql_quantite_stock);
		$requete2->bindParam(1, $id_art, PDO::PARAM_INT);
		$requete2->execute();
		
		if($requete2->rowCount() == 1) {
			$ligne= $requete2->fetch(PDO::FETCH_ASSOC);
			$quantite_stock= $ligne['quantite'];
			$nouvelle_quantite_stock = $quantite_stock - $quantite_commandee;
			
			$sql_mis_a_jour= "UPDATE articles SET quantite= $nouvelle_quantite_stock WHERE id_art= $id_art";
			$requete_mis_a_jour= $bdd1->query($sql_mis_a_jour);
		}
	}
	unset($_SESSION['panier']);
	echo "Votre commande a bien été enregistrée". "<br />" ;
		// fermer la connexion à la base de données 
	$bdd1= null;
	$requete -> closeCursor();
	
?>

</body>
	<a href="index.php">Retour à la page principale</a>

</html>