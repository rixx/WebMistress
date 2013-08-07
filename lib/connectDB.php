<?php
$link = mysql_connect('127.0.0.1', 'rix', 'blakeks');

if (!$link) {
    die('Verbindung schlug fehl: ' . mysql_error());
}

$db = mysql_select_db("viergewinnt",$link);

?>

