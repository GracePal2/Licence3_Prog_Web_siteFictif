<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fruit's Paradise</title>
    <link rel="stylesheet" href="styles/monfichier.css" type="text/css" media="screen" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<?php
session_start();
if (isset($_SESSION['client'])) {
    echo "Vous êtes déjà connecté";
} else {
?>

    <div class="formulaire">
        <div id="message"></div>
            <label for="mail">Email :</label>
            <input type="text" id="mail" name="mail" value="<?php echo isset($_POST['mail']) ? $_POST['mail'] : ''; ?>"><br>

            <label for="mdp1">Mot de passe :</label>
            <input type="password" id="mdp1" name="mdp1"><br>


        <button id="submitBtn">Se connecter</button><br>
    
    </div>

    <script>
        $(document).ready(function() {
            $('#submitBtn').click(function() {
                var formData = {
                    mailc: $('#mail').val(),
                    mdp1c: $('#mdp1').val(),
                    csrf_token: $('[name=csrf_token]').val()
                };

                $.ajax({
                    type: 'POST',
                    url: 'connecter.php',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.connected) {
                            $('#message').html('<div style="color: green;">Connecté avec succès. Redirection en cours...</div>');
                            setTimeout(function() {
                                window.location.href = 'index.php'; // Redirection vers index.php
                            }, 1000);
                        } else {
                            $('#message').html('<div style="color: red;">Erreur de connexion : ' + response.message + '</div>');
                        }
                    },
                    error: function() {
                        console.error('Erreur lors de la requête AJAX de connexion.');
                    }
                });
            });
        });
    </script>
<?php
}
?>
</body>
</html>