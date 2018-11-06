<?php
if (isset ($_SESSION['account']['ip'])){
if($_SERVER['REMOTE_ADDR'] != $_SESSION['account']['ip']){
        header('Location: logout.php');
        exit();
    }
}