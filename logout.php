<?php
session_start();
if(!isset($_SESSION['account'])){
    header("Location index.php");
    exit();
}
unset($_SESSION['account']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Projet 2J</title>
</head>
<body>
    <?php
        include 'php/menu.php';
    ?>
    <h1>Vous êtes désormais déconnecté</h1>
</body>
</html>