<?php
SESSION_start();
    if(isset($_POST['email'], $_POST['password'])){
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $errors[] = 'Email non valide';
        }

        if(!preg_match('/^.{5,500}$/', $_POST['password'])){
            $errors[]= 'Mot de passe non valide';
        }

        if(!isset($errors)){
            try{
                $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
            } catch(Exception $e) {
                die('Erreur : '.$e->getMessage());
            }

            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $getUser = $bdd->prepare('SELECT email, password, insc_date, firstname, lastname, is_active, id FROM users WHERE email= :email');
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
            if (!isset($errors)){
                $_SESSION['account']['email'] = $_POST['email'];
                $_SESSION['account']['name'] = $user['lastname'];
                $_SESSION['account']['firstname'] = $user['firstname'];
                $_SESSION['account']['date'] = $user['insc_date'];
                $_SESSION['account']['id'] = $user['id'];
                $success = 'Vous êtes connecter';
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
    </head>
    <body>
    <?php
     include 'php/menu.php';
    if(!isset($success)){
    ?>
        <form action="login.php" method="post">
            <input type="email" placeholder="email@exemple.com" name="email" required>
            <input type="password" name="password"  required>
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