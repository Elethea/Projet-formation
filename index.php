<?php
// $productsPerPage = 10;
// try{
//     $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
// } catch(Exception $e){
//     die('Erreur de connexion à la bdd');
// }
//     $response = $bdd->prepare('SELECT * FROM products LIMIT :limit ORDER BY p_price ASC');
//     $response->bindValue(':limit', $productsPerPage, PDO::PARAM_INT);
//     $response->execute();
//     $productsToShow = $response->fetchAll(PDO::FETCH_ASSOC);
//     var_dump($productsToShow);
// ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Accueil</title>
</head>
<body>
<?php
    include 'php/menu.php';
?>
</body>
</html>