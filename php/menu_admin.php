<!-- Ceci est une barre de navigation avec les liens relatifs sortant du dossier admin -->
<nav>
    <ul>
        <li><a href="../index.php">Acceuil</a></li>
        <?php
            if (!isset($_SESSION['account']))
            {
        ?>
        <li><a href="../inscription.php">Inscription</a></li>
        <li><a href="../login.php">Connexion</a></li>
        <li><a href="../ask_password_reset.php">Modifier son mot de passe</a></li>
        <?php
            } else {
        ?>
        <li><a href="../logout.php">Déconnexion</a></li>
        <li><a href="../profil.php">Profil</a></li>
        <li><a href="../pagination.php">Articles</a></li>
        <li><a href="admin.php?token=<?php echo $_SESSION['account']['token']; ?>">Admin</a></li>
        <?php
            }
        ?>
    </ul>
</nav>