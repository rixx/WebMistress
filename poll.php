<?php include('auth.php'); ?>
<?php

header('Content-Type: application/json');

session_start();

$link = mysql_connect('127.0.0.1', 'rix', 'blakeks');

if (!$link) {
    echo htmlspecialchars('nope');
    die('Verbindung schlug fehl: ' . mysql_error());
}

$db = mysql_select_db("viergewinnt",$link);
$query = sprintf("select spielfeld, finished from game where id='%s'",$_SESSION['gameid']);
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);


echo '{"board": '.$row['spielfeld'].', "finished": '.$row['finished'].'}';

?>