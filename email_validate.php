<?php
if (isset($_GET['token']) && isset($_GET['email']))
{
    if(!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)){
        $errors[] = 'mail incorrect';
    }
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
    } catch(Exception $e){
        die('Erreur de connexion à la bdd');
    }
    $response = $bdd->prepare('SELECT token FROM users WHERE email = ?');
    $response->execute(array(
        $_GET['email']
    ));
    $user = $response->fetch(PDO::FETCH_ASSOC);
    if ($user['token'] != $_GET['token']){
        $errors[] = 'Erreur';
    } else {
        $response = $bdd->prepare('UPDATE users SET is_active = 1 WHERE email = :email');
        $response->bindValue(':email', $_GET['email']);
        $response->execute();
        $succes = 'Votre compte a bien été validé';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
    include 'php/menu.php';
    if (isset($errors)){
        foreach($errors as $error){
            echo '<p>'.$error.'</p>';
        }
    }
    if (isset($succes)){
        echo $succes;
    }
    ?>
</body>
</html>