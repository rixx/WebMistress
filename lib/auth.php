<?php
    session_start();
    //if someone's not logged in, he's redirected to the login page
    if (!isset($_SESSION['login']) || !$_SESSION['login']) {
        header("HTTP/1.1 303 See Other");
        header('Location: login.php');
        exit;
    }
?>
