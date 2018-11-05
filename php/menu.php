<nav>
    <ul>
        <li><a href="index.php">Acceuil</a></li>
        <?php 
            if (empty($_SESSION['account']))
            {
        ?>
        <li><a href="inscription.php">Inscription</a></li>
        <li><a href="login.php">Connexion</a></li>
        <?php 
            } else {
        ?>
        <li><a href="logout.php">Déconnexion</a></li>
        <li><a href="profil.php">Profil</a></li>
        <?php
            }
        ?>
    </ul>
</nav>