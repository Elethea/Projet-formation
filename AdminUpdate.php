<?php 
session_start();
require 'php/testadmin.php';

if(isset($_POST['delete'])){
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
    } catch (Exception $e){
        Die('Error');
    }
    $response = $bdd->prepare('UPDATE `articles` SET title= :title, content= :content WHERE id = :id');
    $response->bindValue('id', $_POST['DeleteArticles'], PDO::PARAM_INT);
    $response->execute();
    $success = "l\'articles à bien été supprimé";
    
    if(!isset($success)){
     echo "Veuillez recommencer une erreur est survenu";
    }

    
  

} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>lol</title>
</head>
<body>
    <form action="AdminUpdate" method="POST">
        <input type="text" name="title">
        <input type="text" name="content">
    
    
    </form>
    
</body>
</html>