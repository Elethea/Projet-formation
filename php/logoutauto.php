<?php

if($_SERVER['REMOTE_ADDR'] != $_SESSION['account']['ip']){
        header('Location: logout.php');
        exit();
    }

