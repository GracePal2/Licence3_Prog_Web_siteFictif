<?php
require("bd.php");

$mailc = isset($_POST['mailc']) ? $_POST['mailc'] : '';
$mdp1c = isset($_POST['mdp1c']) ? $_POST['mdp1c'] : '';

$bdd = getBD();

session_start();

$query = "SELECT * FROM Clients WHERE mail = :mail";
$stmt = $bdd->prepare($query);
$stmt->bindParam(':mail', $mailc);
$stmt->execute();
$row = $stmt->fetch();

if ($row) {
    $mdp_hache = $row['mdp'];
    if (password_verify($mdp1c, $mdp_hache)) {
        $_SESSION['client'] = array(
            'id_client' => $row['id_client'],
            'nom' => $row['nom'],
            'prenom' => $row['prenom'],
            'adresse' => $row['adresse'],
            'numero' => $row['numero'],
            'mail' => $row['mail'],
			'id_stripe' => $row['id_stripe']
        );
        echo json_encode(array('connected' => true));
        exit();
    } else {
        echo json_encode(array('connected' => false, 'message' => 'Mot de passe incorrect'));
        exit();
    }
} else {
    echo json_encode(array('connected' => false, 'message' => 'Utilisateur non trouvé'));
    exit();
}
?>

	
