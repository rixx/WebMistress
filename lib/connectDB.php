<?php

$host = 'localhost';
$user = 'rix';
$pass = 'blakeks';
$db_name = 'viergewinnt';

$link = mysql_connect($host, $user, $pass);

if (!$link) {
    die('Verbindung schlug fehl: ' . mysql_error());
}

$db = mysql_select_db($db_name, $link);

?>

