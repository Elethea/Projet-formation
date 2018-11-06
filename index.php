<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Accueil</title>
    <style>
        h1{
            font-size : 3rem;
            font-weight : bold;
            color : red;
            text-align : center;
        }
    </style>
</head>
<body>
<?php
    include 'php/menu.php';
?>
<h1>Bienvenue sur la page d'acceuil.</h1>
<?php 
    include 'php/display_user.php';
?>
</body>
</html>