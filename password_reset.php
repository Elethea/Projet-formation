<?php
    if (isset($_GET['email']) && isset($_GET['token'])){
        if(!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)){
            $errors[] = 'mail incorrect';
        }
        try{
            $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
        } catch(Exception $e){
            die('Erreur de connexion à la bdd');
        }
        if (isset($_POST['new_password'])){
            if (!preg_match('#^.{5,500}$#', $_POST['new_password'])){
                $errors[] = 'nouveau mot de passe incorrect';
            } else {
                $response = $bdd->prepare('UPDATE users SET password = ? WHERE email = ?');
                $response->execute(array(
                    password_hash($_POST['new_password'], PASSWORD_BCRYPT),
                    $_GET['email']
                ));
                if ($response->rowCount() == 1){
                    $succes = 'Mdp modifié';
                }
            }
        } else {
            $response = $bdd->prepare('SELECT token FROM users WHERE email = ?');
            $response->execute(array(
            $_GET['email']
            ));
            $user = $response->fetch(PDO::FETCH_ASSOC);
            if ($user['token'] != $_GET['token']){
                $errors[] = 'Erreur';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset</title>
</head>
<body>
    <?php 
    include 'php/menu.php';
            if (!isset($succes)){
            if (isset($_GET['email']) && isset($_GET['token'])){
                echo '<form action="password_reset.php?email='. $_GET['email'] .'&token='. $_GET['token'] .'" method="POST">';
            }
                echo '<form action="password_reset.php" method="POST">';
            ?>
                <input type="text" placeholder="nouveau mot de passe" name="new_password">
                <input type="submit">
            </form>
        <?php
        if (isset($errors)){
            foreach($errors as $error){
                echo '<p>'. $error .'</p>';
            }
        }    
    } else {
        echo $succes;
    }
    
    ?>
</body>
</html>