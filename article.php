<?php
session_start();
require('php/logoutauto.php');
if(!isset($_SESSION['account'])){
    header("Location index.php");
    exit();
}
if(isset($_GET['id']) AND filter_var($_GET['id'], FILTER_VALIDATE_INT) AND $_GET['id'] >= 1){
    $articleId = $_GET['id'];
} else {
    $articleId = 1;
}

try{
    $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : '.$e->getMessage());
}

$getArticle = $bdd->prepare('SELECT * FROM articles WHERE id = :articleId');
$getArticle->bindValue('articleId', $articleId, PDO::PARAM_INT);
$getArticle->execute();

$showArticle= $getArticle->fetch(PDO::FETCH_ASSOC);
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
    include 'php/menu.php';
    ?>

    <main>
        <h1><?php echo htmlspecialchars($showArticle['title'])?></h1>
        <p><?php echo htmlspecialchars($showArticle['content'])?></p>
        <p><?php echo htmlspecialchars($showArticle['author_id'])?></p>
        <p><?php echo date('m-d-Y', htmlspecialchars($showArticle['creation_date']))?></p>
        <a href="pagination.php?page=1">Retour</a>
    </main>
</body>
</html>