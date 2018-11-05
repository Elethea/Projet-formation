<?php
session_start();
    if(isset($_SESSION['account'])){
        header("Location: projet/Projet-formation/index.php");
        exit();
    }
    require('php/recaptcha_valid.php');

    $client_IP = $_SERVER['REMOTE_ADDR'];

    if(isset($_POST['name']) && isset($_POST['firstname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_comfirm']) && isset($_POST['g-recaptcha-response'])){

        if(!isset($_POST['name'])){
            $errors[] = 'votre nom est invalide';
        }

        if(!isset($_POST['firstname'])){
            $errors[] = 'votre prénom est invalide';
        }

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $errors[] = 'Email invalide';
        }

        if(!preg_match('#^.{5,500}$#', $_POST['password'])){
            $errors[] = 'Password invalide';
        }
    
        if($_POST['password'] != $_POST['password_comfirm']){
            $errors[] = 'Confirmation password invalide';
        }

        if(!recaptcha_valid($_POST['g-recaptcha-response'], $client_IP)){
            $errors[] = 'Recaptcha invalide';
        }

        if(!isset($errors)){

            // Connexion à la BDD
            try{
                $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
            } catch(Exception $e){
                die('Erreur de connexion à la bdd');
            }
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Selection du compte (hypothétique) ayant déjà l'adresse email dans le formulaire
            $verifyIfExist = $bdd->prepare('SELECT * FROM users WHERE email = ?');
    
            $verifyIfExist->execute(array(
                $_POST['email']
            ));

            $account = $verifyIfExist->fetch();

            // Si account est vide, c'est que l'email n'est pas utilisée, sinon erreur
            if(empty($account)){
                $token = md5(rand().time().uniqid());
                // Insertion du nouveau compte en BDD
                $response = $bdd->prepare('INSERT INTO users(email, password, lastname, firstname, ip, insc_date, token) VALUES(?,?,?,?,?,?,?)');

                $response->execute(array(
                    $_POST['email'],
                    password_hash($_POST['password'], PASSWORD_BCRYPT),
                    $_POST['name'],
                    $_POST['firstname'],
                    $client_IP,
                    time(),
                    $token
                ));

                // Si la requête SQL a touchée au moins 1 ligne tout vas bien, sinon erreur
                if($response->rowCount() > 0){
                    require ('php/email.php');
                    $success = 'Un mail vous a été envoyer';
                } else {
                    $errors[] = 'Problème lors de la création du compte.';
                }

            } else {
                $errors[] = 'Email déjà utilisée';
            }


        }
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <title>Inscription</title>
</head>
<body>
    <?php
    include 'php/menu.php';
    // Si success n'existe pas, on affiche le formulaire, sinon ona ffiche success
    if(!isset($success)){

    ?>

    <form action="inscription.php" method="post">
        <input type="text" placeholder="nom" name="name">
        <input type="text" placeholder="Prénom" name="firstname">
        <input type="text" placeholder="adresse mail" name="email">
        <input type="text" placeholder="Mot de passe" name="password">
        <input type="text" placeholder="comfirmation" name="password_comfirm">
        <div class="g-recaptcha" data-sitekey="6LeG8HcUAAAAAI9YCD0ZZnModHfaTm8o5irfoKYW"></div>
        <input type="submit" value="S'inscrire">
    </form>
    <?php
    } else {
        echo '<p style="color:green;">' . $success . '</p>';
    }
    
    // Si il y a des erreurs, on les affiches
    if(isset($errors)){
        foreach($errors as $error){
            echo '<p style="color:red;">' . $error . '</p>';
        }
    }
    ?>
</body>
</html>