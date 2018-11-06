<?php

    session_start();
    require '../php/testadmin.php';

    if(isset($_POST['title']) && isset($_POST['content'])){

        if(!preg_match('#^[a-z \'\-_]{2,250}$#i', $_POST['title'])){
            $errors[] = 'ERERUR: Titre incorects';
        }

        if(!preg_match('#^[a-z \'\-_]{2,5000}$#i', $_POST['content'])){
            $errors[] = 'ERERUR: Contenue incorects';
        }

        if(!isset($errors)){
            try{
                $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
            } catch(Exception $e){
                die('Erreur de connexion à la bdd');
            }

            $response = $bdd->prepare('INSERT INTO articles(title, content, creation_date, author_id) VALUES (?,?,?,?)');

            $response->execute(array(
                $_POST['title'],
                $_POST['content'],
                time(),
                $_SESSION['account']['id']
            ));
        }
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrateur/create</title>
</head>
<body>
<?php
    include "../php/menu_admin.php";
    if($admin){


?>
        <form action="AdminCreate.php" method="POST">
            <input type="text" name="title">
            <input type="text" name="content">
            <input type="submit">
        </form>
<?php
    if(isset($errors)){
        foreach ($errors as $error){
            echo $error;
        }

    }
} ?>
</body>
</html>