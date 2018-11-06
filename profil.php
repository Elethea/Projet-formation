<?php
    session_start();
    if(!isset($_SESSION['account'])){
        header("Location index.php");
        exit();
    }
    if(isset($_SESSION['account']['email']) && isset($_SESSION['account']['name'])  && isset($_SESSION['account']['firstname']) && isset($_SESSION['account']['date'])){
        $user_data = array(
            'email' => $_SESSION['account']['email'],
            'name' => $_SESSION['account']['name'],
            'firstname' => $_SESSION['account']['firstname'],
            'date' => $_SESSION['account']['date']
        );
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
                echo '<li>Adresse mail : '. $user_data['email'] .'</li><li>Nom : '. $user_data['name'] .'</li><li>Prénom : '. $user_data['firstname'] .'</li><li>Date d\'inscription : '. date('d-m-Y', $user_data['date']) .'</li>';
            } else {
                echo 'Vous n\'êtes pas connecté';
            }
        ?>
    </ul>
</body>
</html>