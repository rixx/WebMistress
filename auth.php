<?php
    session_start();

    //if someone's not logged in, he's redirected to the login page
    if (!isset($_SESSION['login']) || !$_SESSION['login']) {
        header('Location: login.php');
        exit;
    }
?>
