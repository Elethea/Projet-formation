<?php 
 session_start();
 require('php/testadmin.php');
 require('php/logoutauto.php');


if(isset($_POST['DeleteArticles'])){
    if(!filter_var($_POST['DeleteArticles'], FILTER_VALIDATE_INT)){
        $errors[] = "Veuillez entrer un entier";
    }
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
    } catch (Exception $e){
        Die('Error');
    }
    $response = $bdd->prepare('DELETE FROM articles WHERE id = :id ');
    $response->bindValue('id', $_POST['DeleteArticles'], PDO::PARAM_INT);
    $response->execute();
    if($response->rowCount() != 1){
        echo "Veuillez recommencer une erreur est survenu";
    } else {
        $success = "l\'articles à bien été supprimé";
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
    <?php if($admin){?>
<form action="AdminDelete.php" method="POST">
    <input type="text" name="DeleteArticles" placeholder="Entrer un numéro d'articles pour le supprimer">
    <input type="submit" name="delete" value="Delete">
</form>

    <?php
    if($errors){
        foreach($errors as $error){
            echo $error;
        }
    } else {
        $success;
    }
} ?>
    
</body>
</html>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         