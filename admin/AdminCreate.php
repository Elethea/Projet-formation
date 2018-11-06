<?php

    session_start();

    // On inclus notre fichier qui vérifie le niveau de droit de l'utilisateur dans la bdd
    require '../php/testadmin.php';

    // On verifie si le formulaire est bien remplis
    if(isset($_POST['title']) && isset($_POST['content'])){

        // On vérifie si le contenu du formulaire correspond à nos attentes
        if(!preg_match('#^.{2,250}$#', $_POST['title'])){
            $errors[] = 'ERERUR: Titre incorects';
        }

        if(!preg_match('#^.{2,5000}$#', $_POST['content'])){
            $errors[] = 'ERERUR: Contenue incorects';
        }

        if(!isset($errors)){
            // Connexion à la bdd
            try{
                $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
            } catch(Exception $e){
                die('Erreur de connexion à la bdd');
            }

            // Insertion du contenu du formulaire dans le tableau article
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
    // Inclusion du menu avec les liens relatifs partant du dossier admin
    include "../php/menu_admin.php";

    if($admin&& isset($_GET['token'])){

        if($_GET['token'] == $_SESSION['account']['token']){


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
        }else {
            die('Jeton de session invalide');
        }
    } ?>
</body>
</html>