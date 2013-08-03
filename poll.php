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
$query = sprintf("select spielfeld, finished, turn from game where id='%s'",$_SESSION['gameid']);
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);

    if ($row['finished'] == 'true') {
        echo '{"board": '.$row['spielfeld'].', "finished": true, "turn": '.$row['turn'].'}';
    } else {
        echo '{"board": '.$row['spielfeld'].', "finished": false, "turn": '.$row['turn'].'}';
    }
?>
