<?php
session_start();
if(isset($_SESSION['account'])){
    header('Location: index.php');
    exit();
}
require('php/recaptcha_valid.php');
$client_IP = $_SERVER['REMOTE_ADDR'];

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
        try{
            $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
        } catch(Exception $e) {
            die('Erreur : '.$e->getMessage());
        }
        $response = $bdd->prepare('SELECT ip, tentative, co_time FROM users WHERE email = ?');
        $response->execute(array(
            $_POST['email']
        ));
        $oui = $response->fetch(PDO::FETCH_ASSOC);
        if(!isset($errors)){


            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $getUser = $bdd->prepare('SELECT email, password, insc_date, firstname, lastname, is_active, id, statut, ip FROM users WHERE email= :email');
            $getUser->bindValue('email', $_POST['email']);
            $getUser->execute();

            $user = $getUser -> fetch(PDO::FETCH_ASSOC);
            if(empty($user)){
                $errors[] = 'Adresse mail incorrect';
            }
            if ($user['is_active'] == 0){
                $errors[] = 'Votre compte n\'est pas actif';
            }
            if (!password_verify($_POST['password'], $user['password'])){
                $errors[] = 'Mot de passe incorrect';
            }
            if (!isset($errors) && (time() >= $oui['co_time'])){
                $_SESSION['account']['email'] = htmlspecialchars($_POST['email']);
                $_SESSION['account']['name'] = htmlspecialchars($user['lastname']);
                $_SESSION['account']['firstname'] = htmlspecialchars($user['firstname']);
                $_SESSION['account']['date'] = htmlspecialchars($user['insc_date']);
                $_SESSION['account']['id'] = htmlspecialchars($user['id']);
                $_SESSION['account']['statut'] = htmlspecialchars($user['statut']);
                $_SESSION['account']['ip'] = htmlspecialchars($_SERVER['REMOTE_ADDR']);

                if (!isset($_SESSION['account']['token'])){
                    $_SESSION['account']['token'] = md5(bin2hex(openssl_random_pseudo_bytes(6)));
                }

                $success = 'Vous êtes connecter';
            } else{
                $errors[] = "Connexion impossible vous êtes bloqué jusqu'à : ".date("H\h:i\m:s\s", $oui['co_time']);
            }
        }
        if(isset($errors)){
            if(isset($oui)){
                if(time() >= $oui['co_time']){
                    if($oui['tentative'] == 10){
                        $response = $bdd->prepare('UPDATE `users` SET tentative = :tenta , co_time = :time');
                        $response->bindValue(':tenta', 0);
                        $response->bindValue(':time', time()+(15*60), PDO::PARAM_INT);
                        $response->execute();
                    } else {
                        if($client_IP == $oui['ip']){
                            $response = $bdd->prepare('UPDATE `users` SET tentative= ?');
                            $response->execute(array(
                                $oui['tentative'] + 1
                            ));
                        } else{
                            $response = $bdd->prepare('UPDATE `users` SET ip = ? , tentative = ?');
                            $response->execute(array(
                                $client_IP,
                                0
                            ));
                        }
                    }
                }              
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
        }

        if(isset($errors)){
            foreach($errors as $error){
                echo $error;
            }

        } else {
            if(isset($success)){
                echo $success;
            }

        }
    ?>
    </body>
</html>