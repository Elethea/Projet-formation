<?php

    session_start();
    require '../php/testadmin.php';
    if(isset($_GET['token'])){
        if($_GET['token'] != $_SESSION['account']['token']){

        }
    } else

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
    include "../php/menu_admin.php";
    if($admin && isset($_GET['token']){
        if($_GET['token'] == $_SESSION['account']['token']){


?>
    <a href="AdminDelete.php?token=<?php echo $_SESSION['account']['token']; ?>">Suprimer</a>
    <a href="AdminCreate.php?token=<?php echo $_SESSION['account']['token']; ?>">Ajouter</a>
    <a href="AdminChange.php?token=<?php echo $_SESSION['account']['token']; ?>"></a>
    <?php
        }else {
            die('Jeton de session invalide');
        }
    } ?>
</body>
</html>