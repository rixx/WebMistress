<?php include('auth.php'); ?>
<?php
session_start();

include('connectDB.php');
include('exitRemaining.php');

session_destroy();

header('Location: index.html');
?>
