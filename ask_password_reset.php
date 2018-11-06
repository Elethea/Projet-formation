<?php
require('php/logoutauto.php');
if(isset($_SESSION['account'])){
    header("Location index.php");
    exit();
}
if (isset($_POST['email'])){
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors[] = 'mail incorrect';
    }
    if (!isset($errors)){
        try{
            $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
        } catch(Exception $e){
            die('Erreur de connexion à la bdd');
        }
        $verifyIfExist = $bdd->prepare('SELECT * FROM users WHERE email = ?');
        $verifyIfExist->execute(array(
            $_POST['email']
        ));
        $account = $verifyIfExist->fetch();
        if(!empty($account)){
            $token = md5(rand().time().uniqid());
            $response = $bdd->prepare('UPDATE users SET token = ? WHERE email = ?');
            $response->execute(array(
                $token,
                $_POST['email']
            ));
            if($response->rowCount() == 1){
                require 'php/email_reset.php';
                $success = 'Un mail vous a été envoyer';
            }
        } else {
            $errors[] = 'mail inexistant';
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
    <title>ask for Reset</title>
</head>
<body>
<?php
include 'php/menu.php';
    if (!isset($success)){
?>
    <form action="ask_password_reset.php" method="POST">
        <input type="text" placeholder="adresse mail" name="email">
        <input type="submit">
    </form>
    <?php
    if (isset($errors)){
        foreach($errors as $error){
            echo '<p>'. $error .'</p>';
        }
    }
    } else {
        echo $success;
    }
    ?>
</body>
</html>