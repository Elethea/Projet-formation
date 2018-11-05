<?php
require('php/recaptcha_valid.php');
$client_IP = $_SERVER['REMOTE_ADDR'];

SESSION_start();
    if(isset($_POST['email'], $_POST['password'], $_POST['g-recaptcha-response'])){
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $errors[] = 'Email non valide';
        }

        if(!preg_match('/^.{5,500}$/', $_POST['password'])){
            $errors[]= 'Mot de passe non valide';
        }

        if(!recaptcha_valid($_POST['g-recaptcha-response'], $client_IP)){
            $errors[] = 'Recaptcha invalide';
        }

        if(!isset($errors)){
            try{
                $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
            } catch(Exception $e) {
                die('Erreur : '.$e->getMessage());
            }

            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $getUser = $bdd->prepare('SELECT email, password, insc_date, firstname, lastname FROM users WHERE email= :email');
            $getUser->bindValue('email', $_POST['email']);
            $getUser->execute();

            $user = $getUser -> fetch(PDO::FETCH_ASSOC);

            if(!empty($user)){
                if(password_verify($_POST['password'], $user['password'])){
                    $_SESSION['account']['email'] = $_POST['email'];
                    $_SESSION['account']['name'] = $user['lastname'];
                    $_SESSION['account']['firstname'] = $user['firstname'];
                    $_SESSION['account']['date'] = $user['insc_date'];

                    $success = 'Vous êtes connecter';
                } else {
                    $errors[] = 'Mot de passe invalide';
                }
            }else{
                $errors[] = 'Il n\'existe pas de compte avec cet email';
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
        <title>se connecter</title>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body>
    <?php
     include 'php/menu.php';
    if(!isset($success)){
    ?>
        <form action="login.php" method="post">
            <input type="email" placeholder="email@exemple.com" name="email" required>
            <input type="password" name="password"  required>
            <div class="g-recaptcha" data-sitekey="6LeG8HcUAAAAAI9YCD0ZZnModHfaTm8o5irfoKYW"></div>
            <input type="submit" value="Connexion">
        </form>
    <?php
        if(isset($errors)){
            foreach($errors as $error){
                echo $error;
            }
        }
    } else {
        echo $success;
    }
    ?>
    </body>
</html>