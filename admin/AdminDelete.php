<?php
 session_start();
 require '../php/testadmin.php';

if(isset($_POST['DeleteArticles'])){
    if(!filter_var($_POST['DeleteArticles'], FILTER_VALIDATE_INT)){
        $errors[] = "Veuillez entrer un entier";
    }
    if (!isset($errors)){
        try{
            $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
        } catch (Exception $e){
            Die('Error');
        }
        $response = $bdd->prepare('DELETE FROM articles WHERE id = :id ');
        $response->bindValue('id', $_POST['DeleteArticles'], PDO::PARAM_INT);
        $response->execute();
        if($response->rowCount() != 1){
            $errors[] =  "Veuillez recommencer une erreur est survenu";
        } else {
            $success = "l\'articles à bien été supprimé";
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
    <title>Document</title>
</head>
<body>
    <?php
    include '../php/menu_admin.php';

    if($admin&& isset($_GET['token']){
        if($_GET['token'] == $_SESSION['account']['token']){?>

<form action="AdminDelete.php" method="POST">
    <input type="text" name="DeleteArticles" placeholder="Entrer un numéro d'articles pour le supprimer">
    <input type="submit" name="delete" value="Delete">
</form>

    <?php

            if(isset($errors)){
                foreach($errors as $error){
                    echo $error;
                }
            }
            if (isset($succes)){
                echo $succes;
            }
        }else {
            die('Jeton de session invalide')
        }
    } ?>
</body>
</html>