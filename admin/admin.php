<?php

    session_start();

    // On inclus notre fichier qui vérifie le niveau de droit de l'utilisateur dans la bdd
    require '../php/testadmin.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrateur</title>
</head>
<body>
<?php
    // Inclusion du menu avec les liens relatifs partant du dossier admin
    include "../php/menu_admin.php";

    // On vérifie si la personne est bien admin et si le token de connexion est fournis
    if($admin && isset($_GET['token'])){

        // On vérifie la véracité du cookie de connexion en le comparant à celui générer plus tôt
        if($_GET['token'] == $_SESSION['account']['token']){


?>
    <a href="AdminDelete.php?token=<?php echo $_SESSION['account']['token']; ?>">Suprimer</a>
    <a href="AdminCreate.php?token=<?php echo $_SESSION['account']['token']; ?>">Ajouter</a>
    <a href="AdminChange.php?token=<?php echo $_SESSION['account']['token']; ?>">Modifier</a>
    <?php

        // Si le token ne correspond pas on coupe toutes fonctionnalités php et affiche une erreur
        }else {
            die('Jeton de session invalide');
        }
    } ?>
</body>
</html>