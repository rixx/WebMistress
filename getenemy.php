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
$query = sprintf("select game.player2, player.name from game left join player
                    on game.player2=player.id
                    where game.id='%s'", $_SESSION['gameid']);
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);

if (!empty($row['player2'])) {
    echo '{"enemy": "'.$row['name'].'"}';
} else {
    echo '{"error": "no enemy defined"}';
}

?>
