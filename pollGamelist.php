<?php header('Content-Type: application/json');?>
<?php include('auth.php'); ?>
<?php

include('connectDB.php');

// get list of all games with only one player
$query = sprintf("SELECT game.name AS gamename, player.name AS player1name
                  FROM game
                      JOIN player on game.player1=player.id
                  WHERE game.player2 IS NULL AND game.finished='false'");
$result = mysql_query($query);

$returnArr = array();

while ($row = mysql_fetch_assoc($result)) {
    $returnArr[] = $row;
}

echo(json_encode($returnArr));
