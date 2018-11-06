<?php
if (isset($_SESSION['account']['name']) && isset($_SESSION['account']['firstname'])){
    echo 'Vous êtes connecté en tant que : '.$_SESSION['account']['name'].' ' .$_SESSION['account']['firstname'].'.';
} else {
    echo 'Vous n\'etes pas connecté.';
}