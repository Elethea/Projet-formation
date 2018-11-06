<?php
if($_SESSION['account']['statut'] == 0){ //ceci sert a tester si on est admin
        $errors[] = 'vous n\'etes pas admin';
        $admin = false;
    } else {
        $admin = true;
    }