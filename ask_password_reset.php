<?php
<<<<<<< HEAD
// Vérification de la connexion à un compte et si il est connecter on le renvoi sur "Index.php"
=======
require('php/logoutauto.php');
>>>>>>> 1c6f7a36946b1483dd431d1a732e02c25418cdb4
if(isset($_SESSION['account'])){
    header("Location index.php");
    exit();
}
// Champ de vérification de l'email avec un Filter_var
if (isset($_POST['email'])){
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors[] = 'mail incorrect'; // Envoi une erreur si l'email est mal rentré
    }
    if (!isset($errors)){ // Si il n'y as pas d'erreurs on entre dans la bdd
        try{
            $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', ''); // Initialisation du chemin jusqu'à la base de donnée
        } catch(Exception $e){
            die('Erreur de connexion à la bdd');
        }
        $verifyIfExist = $bdd->prepare('SELECT * FROM users WHERE email = ?'); // Verification si l'email existe dans la base de donnée
        $verifyIfExist->execute(array(
            $_POST['email']
        ));
        $account = $verifyIfExist->fetch(); // Créer un tableau html qui nous envoi tout ce qu'on as récupérer dans la base de donnée
        if(!empty($account)){ // On vérifie si le compte n'est pas vide
            $token = md5(rand().time().uniqid()); // Génération d'un token aléatoire
            $response = $bdd->prepare('UPDATE users SET token = ? WHERE email = ?'); // Requête pour mettre à jour le token de l'utilisateur avec un e-mail précis
            $response->execute(array( // tableau où l'on execute un tableau
                $token,
                $_POST['email']
            ));
            if($response->rowCount() == 1){ // Si rowCount est égal à 1  donc si il n'y as aucune erreur Un mail est envoyer
                require 'php/email_reset.php'; // Importation de la page "Email-reset"
                $success = 'Un mail vous a été envoyer'; // Message de succès pour l'e-mail envoyer
            }
        } else { // Dans le cas contraire 
            $errors[] = 'mail inexistant'; // Envoi ce message d'erreur si l'e-mail entrée n'est pas présent dans la base de donnée
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
    <title>ask for Reset</title>
</head>
<body>
<?php
include 'php/menu.php'; // Inclusion du menu 
    if (!isset($success)){ // Si il n'y a une erreur on affiche le formulaire 
?>
    <form action="ask_password_reset.php" method="POST">
        <input type="text" placeholder="adresse mail" name="email">
        <input type="submit">
    </form>
    <?php
    if (isset($errors)){ // Boucle pour les erreurs
        foreach($errors as $error){ // Pour chaque erreurs qui sont egal à erreur 
            echo '<p>'. $error .'</p>'; // On envoi l'erreur 
        }
    }
    } else { // Dans le cas contraire si aucune erreur n'est faite
        echo $success; // On envoi le message de succès
    }
    ?>
</body>
</html>