<?php
    SESSION_start();
    $_SESSION['email'] = 'cyrilcuvelier@sfr.fr';
    $_SESSION['name'] = 'Cuvelier';
    $_SESSION['firstname'] = 'Cyril';
    $_SESSION['date'] = time();
    if(isset($_SESSION['email']) && isset($_SESSION['name'])  && isset($_SESSION['firstname']) && isset($_SESSION['date'])){
        $user_data = array(
            'email' => $_SESSION['email'],
            'name' => $_SESSION['name'],
            'firstname' => $_SESSION['firstname'],
            'date' => date('d-m-Y', $_SESSION['date'])
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
            echo '<li>Adresse mail : '. $user_data['email'] .'</li><li>Nom : '. $user_data['name'] .'</li><li>Prénom : '. $user_data['firstname'] .'</li><li>Date d\'inscription : '. $user_data['date'] .'</li>';
        ?>
    </ul>
</body>
</html>