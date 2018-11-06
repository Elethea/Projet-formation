<?php 

    try{
        $bdd = new PDO(host=locahost;dbname=projet;charset=utf8, 'root', '')
    } catch (Exception $e){
        Die('Error');
    }
    $response = $bdd->prepare('DELETE FROM articles WHERE id = ? ');
    $response->execute



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="DeleteArticles" method="POST">

    <input type="submit" name="delete" value="Delete">

</form>
    
</body>
</html>