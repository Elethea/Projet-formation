<?php
$articlesPerPage = 10;

if(isset($_GET['page']) AND filter_var($_GET['page'], FILTER_VALIDATE_INT) AND $_GET['page'] >= 1){
    $page = $_GET['page'];
} else {
    $page = 1;
}
$offset = $page * $articlesPerPage - $articlesPerPage;

try{
    $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : '.$e->getMessage());
}

$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$getArticles = $bdd->prepare('SELECT * FROM articles ORDER BY creation_date DESC LIMIT :limit OFFSET :offset');
$getArticles->bindValue(':limit', $articlesPerPage, PDO::PARAM_INT);
$getArticles->bindValue(':offset', $offset, PDO::PARAM_INT);
$getArticles->execute();

$showArticles= $getArticles->fetchALL(PDO::FETCH_ASSOC);

$getArticles = $bdd->query('SELECT title FROM articles');

$numberOfArticles= $getArticles->fetchALL(PDO::FETCH_NUM);

$lastPage = ceil(count($numberOfArticles) / $articlesPerPage);

?>
<!DOCTYPE html>
<html lang=fr>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <style>
    td,
    th{
        border: black 1px solid;
        padding : 0.5rem;
    }

    table{
        border-collapse: collapse;
    }

    a{
        text-decoration: none;
    }
    </style>

    <?php
        if(!empty($showArticles)){
    ?>
    <nav>
    <?php
    include 'php/menu.php';
    ?>
    </nav>

    <table>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Date</th>
            <th>Liens</th>
    <?php
        foreach($showArticles as $articles){
            echo '<tr><td>'.htmlspecialchars($articles['title']).'</td><td>'.htmlspecialchars($articles['author_id']).'</td><td>'.date('d-m-Y', $articles['creation_date']).'</td><td><a href="article.php?id='.$articles['id'].'">En savoir plus</a></td></tr>';
        }
    ?>
    </table>
    <?php
        } else {
            echo 'Pas d\'articles trouver';
        }
    ?>

    <?php if($page > 1){ ?>
    <a href="pagination.php?page=1"><</a>
    <a href="pagination.php?page=<?php echo htmlspecialchars($page) - 1;?>">Précedent</a>
    <?php } ?>

    <?php if($page > 2){ ?>
    <a href="pagination.php?page=<?php echo htmlspecialchars($page) - 2;?>"><?php echo htmlspecialchars($page) - 2;?></a>
    <?php } ?>

    <?php if($page > 1){ ?>
    <a href="pagination.php?page=<?php echo htmlspecialchars($page) - 1;?>"><?php echo htmlspecialchars($page) - 1;?></a>
    <?php } ?>

    <a href="pagination.php?page=<?php echo htmlspecialchars($page);?>"><?php echo htmlspecialchars($page);?></a>

    <?php if($page < $lastPage){ ?>
    <a href="pagination.php?page=<?php echo htmlspecialchars($page) + 1;?>"><?php echo htmlspecialchars($page) + 1;?></a>
    <?php } ?>

    <?php if($page < ($lastPage - 1)){ ?>
    <a href="pagination.php?page=<?php echo htmlspecialchars($page) + 2;?>"><?php echo htmlspecialchars($page) + 2;?></a>
    <?php } ?>

    <?php if($page < $lastPage){ ?>
    <a href="pagination.php?page=<?php echo htmlspecialchars($page) + 1;?>">Suivant</a>
    <a href="pagination.php?page=<?php echo htmlspecialchars($lastPage) ?>">></a>
    <?php } ?>

    <p>
    <?php $count = 0;
    for($i = 0; $i < ceil($lastPage/$articlesPerPage)-1; $i++){
        $count += $articlesPerPage; ?>
    <a href="pagination.php?page=<?php echo $count;?>"><?php echo $count;?></a>
    <?php } ?>
    </p>
</body>
</html>