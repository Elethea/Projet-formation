<?php
if (isset($_SESSION['account']['name']) && isset($_SESSION['account']['firstname'])){
    echo 'Vous êtes connecté en tant que : '.htmlspecialchars($_SESSION['account']['name']).' ' .htmlspecialchars($_SESSION['account']['firstname']).'.';
} else {
    echo 'Vous n\'etes pas connecté.';
}