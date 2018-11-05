<?php
if($_SESSION['account']['statut'] == 0){
        $errors[] = 'vous ete pas admin';
        $admin = false;
    } else {
        $admin = true;
    }