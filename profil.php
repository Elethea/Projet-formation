<?php
    session_start();
    require('php/logoutauto.php');
    if(!isset($_SESSION['account'])){
        header("Location index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil</title>
</head>
<body>
<?php
    include 'php/menu.php';
?>
    <ul>
        <?php
            if (isset($user_data)){
                echo '<li>Adresse mail : '. htmlspecialchars($_SESSION['account']['email']) .'</li><li>Nom : '. htmlspecialchars($_SESSION['account']['name']) .'</li><li>Prénom : '. htmlspecialchars($_SESSION['account']['firstname']) .'</li><li>Date d\'inscription : '. date('d-m-Y', htmlspecialchars($_SESSION['account']['name'])) .'</li>';
            } else {
                echo 'Vous n\'êtes pas connecté';
            }
        ?>
    </ul>
</body>
</html>