<?php 

    session_start();
    require 'php/testadmin.php';

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
    include "php/menu.php";
    if($admin){

    
?>
    <a href="AdminDelete.php">Suprimer</a>
    <a href="AdminCreate.php">Ajouter</a>
    <a href=""></a>
    <?php } ?>
</body>
</html>