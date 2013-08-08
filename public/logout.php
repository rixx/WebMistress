<?php 
include('../lib/auth.php'); 
include('../lib/connectDB.php');
include('../lib/exitRemaining.php');

session_destroy();
header("HTTP/1.1 303 See Other");
header('Location: index.php');
?>
