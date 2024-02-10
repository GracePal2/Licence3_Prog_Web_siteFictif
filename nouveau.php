<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Client</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fonction pour vérifier l'existence de l'e-mail
            function verifierEmail(email, callback) {
                $.ajax({
                    type: 'POST',
                    url: 'verifier_email.php',
                    data: { email: email },
                    dataType: 'json',
                    success: function(response) {
                        callback(response.existe);
                    }
                });
            }

            // Fonction pour mettre à jour le champ e-mail en temps réel
            $('#mail').on('input', function() {
                var email = $(this).val().trim();

                // Vérifie l'existence de l'e-mail
                verifierEmail(email, function(existe) {
                    if (existe) {
                        $('#mail').css('border-color', 'red');
                        $('#mail').next('.error-msg').text('Cette adresse e-mail existe déjà.');
                    } else {
                        $('#mail').css('border-color', 'green');
                        $('#mail').next('.error-msg').text('');
                    }
                });
            });

            // Fonction pour inscrire l'utilisateur via AJAX
            function inscrireUtilisateur() {
                // Récupérer les données du formulaire
                var formData = $('form').serialize();

                $.ajax({
                    type: 'POST',
                    url: 'enregistrement.php', // Ajoutez le chemin vers votre script de traitement PHP
                    data: formData,
                    success: function(response) {
                        // Analyser la réponse du serveur
                        if (response.success) {
                            var login = {
                                mailc: $('#mail').val(),
                                mdp1c: $('#mdp1').val(),
                            };

                            $.ajax({
                                type: 'POST',
                                url: 'connecter.php', // Ajoutez le chemin vers votre script de traitement PHP
                                data: login,
                                success: function(response) {
                                    setTimeout(function() {
                                        window.location.href = 'index.php'; // Ajoutez le chemin vers votre page d'accueil
                                    }, 1000);
                                },
                                error: function() {
                                    // Gérer les erreurs de connexion
                                    $('#message').text('Erreur lors de la connexion après l\'inscription.');
                                    $('#message').css('color', 'red');
                                }
                            });
                        } else {
                            // Erreur : afficher un message d'erreur
                            $('#message').text(response.message);
                            $('#message').css('color', 'red');
                        }
                    },
                    error: function() {
                        // Erreur lors de la requête AJAX
                        $('#message').text('Une erreur s\'est produite lors de la création du compte.');
                        $('#message').css('color', 'red');
                    }
                });
            }

            // Gérer la soumission du formulaire
            $('form').submit(function(event) {
                event.preventDefault();
                var valid = true;

                // Fonction de validation pour chaque champ
                function validateField(field, regex, errorMessage) {
                    var value = $(field).val().trim();
                    if (value === '' || (regex && !regex.test(value))) {
                        valid = false;
                        $(field).css('border-color', 'red');
                        $(field).next('.error-msg').text(errorMessage);
                    } else {
                        $(field).css('border-color', 'green');
                        $(field).next('.error-msg').text('');
                    }
                }

                // Vérification du champ Nom
                validateField('#n', null, 'Veuillez entrer votre nom.');

                // Vérification du champ Prénom
                validateField('#p', null, 'Veuillez entrer votre prénom.');

                // Vérification du champ Adresse
                validateField('#adr', null, 'Veuillez entrer votre adresse.');

                // Vérification du champ Numéro de téléphone
                validateField('#num', null, 'Veuillez entrer votre numéro de téléphone.');

                // Vérification du champ Adresse e-mail
                validateField('#mail', /^[^\s@]+@[^\s@]+\.[^\s@]+$/, 'Veuillez entrer une adresse e-mail valide.');

                // Vérification du champ Mot de passe
                validateField('#mdp1', /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/, 'Le mot de passe doit contenir au moins 1 lettre, 1 chiffre et 1 caractère spécial.');

                // Vérification de la confirmation du mot de passe
                validateField('#mdp2', null, 'Les mots de passe ne correspondent pas.');

                // Si tous les champs sont valides, inscrire l'utilisateur via AJAX
                if (valid) {
                    inscrireUtilisateur();
                }
            });
        });
    </script>
</head>
<body>
    <header>
        <h1>Nouveau Client</h1>
    </header>

    <main>
        <form action="enregistrement.php" method="post">
            <label for="n">Nom :</label>
            <input type="text" id="n" name="n" required value="<?php echo isset($_GET['n']) ? $_GET['n'] : ''; ?>">
            <span class="error-msg"></span><br>

            <label for="p">Prénom :</label>
            <input type="text" id="p" name="p" required value="<?php echo isset($_GET['p']) ? $_GET['p'] : ''; ?>">
            <span class="error-msg"></span><br>

            <label for="adr">Adresse :</label>
            <input type="text" id="adr" name="adr" required value="<?php echo isset($_GET['adr']) ? $_GET['adr'] : ''; ?>">
            <span class="error-msg"></span><br>

            <label for="num">Numéro de téléphone :</label>
            <input type="text" id="num" name="num" required value="<?php echo isset($_GET['num']) ? $_GET['num'] : ''; ?>">
            <span class="error-msg"></span><br>

            <label for="mail">Adresse e-mail :</label>
            <input type="text" id="mail" name="mail" required value="<?php echo isset($_GET['mail']) ? $_GET['mail'] : ''; ?>">
            <span class="error-msg"></span><br>

            <label for="mdp1">Mot de passe :</label>
            <input type="password" id="mdp1" name="mdp1" required>
            <span class="error-msg"></span><br>

            <label for="mdp2">Confirmer votre mot de passe :</label>
            <input type="password" id="mdp2" name="mdp2" required>
            <span class="error-msg"></span><br>

            <input type="submit" value="S'inscrire">
        </form>
    </main>

    <footer>
        <a href="index.php">Retour à l'accueil</a>
    </footer>
</body>
</html>
