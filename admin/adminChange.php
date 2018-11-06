<?php
session_start();

// Fichier vérif droit admin
require '../php/testadmin.php';

// Verif formulaire completer
if(isset($_POST['title'], $_POST['content'], $_POST['id'])){

    // Verif contenu correcte
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

        // Connexion BDD
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

            // Verif succès requête SQL
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
    // Inclusion menu liens relatifs dossier admin
    include '../php/menu_admin.php';

    // Verif admin + présence token de connexion
    if($admin&& isset($_GET['token'])){

        // Verif véracité token
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
            // Affichage succès
            } else {
                echo '<p style="color:green;">' . $success . '</p>';
            }

            // Affichage erreurs
            if(isset($errors)){
                foreach($errors as $error){
                    echo '<p style="color:red;">' . $error . '</p>';
                }
            }

        // Stop PHP si token invalide
        }else {
            die('Jeton de session invalide');
        }
    }?>
</body>
</html>