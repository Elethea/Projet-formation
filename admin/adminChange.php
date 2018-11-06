<?php
session_start();

// On inclus notre fichier qui vérifie le niveau de droit de l'utilisateur dans la bdd
require '../php/testadmin.php';

// On verifie si le formulaire est bien remplis
if(isset($_POST['title'], $_POST['content'], $_POST['id'])){

    // On vérifie si le contenu du formulaire correspond à nos attentes
    if(!preg_match('#^.{2,250}$#',$_POST['title'])){
        $errors[] = 'Votre titre est invalide';
    }

    if(!preg_match('#^.{2,5000}$#',$_POST['content'])){
        $errors[] = 'Votre contenu est invalide';
    }

    if(!preg_match('#^[0-9]{1,}$#',$_POST['id'])){
        $errors[] = 'L\'Id saisis est invalide';
    }

    if(!isset($errors)){

        // Connexion à la BDD
        try{
            $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
        } catch(Exception $e){
            die('Erreur de connexion à la bdd');
        }
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $verifyIfExist = $bdd->prepare('SELECT * FROM articles WHERE id = ?');

        $verifyIfExist->execute(array(
            $_POST['id']
        ));

        $article = $verifyIfExist->fetch(PDO::FETCH_ASSOC);

        if(isset($article['id'])){
            $response = $bdd->prepare('UPDATE articles SET content = ? , title = ? WHERE id = ?');

            $response->execute(array(
                $_POST['content'],
                $_POST['title'],
                $_POST['id']
            ));

            // Si la requête SQL a touchée au moins 1 ligne tout vas bien, sinon erreur
            if($response->rowCount() > 0){
                $success = 'Article modifié avec succès';
            } else {
                $errors[] = 'Problème lors de la modification de l\'article.';
            }

        } else {
            $errors[] = 'Article inexistant';
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
    <title>Projet-Formation</title>
</head>
<body>
    <h1>Modification Article</h1>

    <?php
    // Inclusion du menu avec les liens relatifs partant du dossier admin
    include '../php/menu_admin.php';

    // On vérifie si la personne est bien admin et si le token de connexion est fournis
    if($admin&& isset($_GET['token'])){

        // On vérifie la véracité du cookie de connexion en le comparant à celui générer plus tôt
        if($_GET['token'] == $_SESSION['account']['token']){

            // Si success n'existe pas, on affiche le formulaire, sinon on affiche success
            if(!isset($success)){

    ?>
    <form action="adminChange.php" method="POST">
        <input type="text" name="id" placeholder="Id de l'article à modifier">
        <input type="text" name="title" placeholder="Titre">
        <input type="text" name="content" placeholder="Contenu">
        <input type="submit" value="Valider">
    </form>
    <?php
            } else {
                echo '<p style="color:green;">' . $success . '</p>';
            }

            // Si il y a des erreurs, on les affiches
            if(isset($errors)){
                foreach($errors as $error){
                    echo '<p style="color:red;">' . $error . '</p>';
                }
            }

        // Si le token ne correspond pas on coupe toutes fonctionnalités php et affiche une erreur
        }else {
            die('Jeton de session invalide');
        }
    }?>
</body>
</html>