<?php 
include('../lib/auth.php'); 

session_start();

include('../lib/connectDB.php');
include('../lib/exitRemaining.php');

session_destroy();

header('Location: index.html');
?>
