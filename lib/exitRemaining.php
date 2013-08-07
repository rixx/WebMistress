<?php

// all games in which the current player is involved, are marked as finished
// this prevents players from playing multiple games simultaniously
$query = sprintf("SELECT id, player1, player2
                  FROM game 
                  WHERE game.finished='false' 
                      AND (player1='%s' OR player2='%s')",
                  $_SESSION['uid'],$_SESSION['uid']);

$result = mysql_query($query);

while ($row = mysql_fetch_assoc($result)) {

    // find enemy
    $otherplayer = ($row['player1'] == $_SESSION['uid']) ? $row['player2'] : $row['player1'];

    // set the game to finished
    $query = sprintf("UPDATE game SET finished='true' WHERE id='%s'",$row['id']);
    mysql_query($query);

    // increment won and played games for the other player
    $query = sprintf("UPDATE player 
                      SET won = won + 1, played = played + 1 
                      WHERE id = '%s'",
                      $otherplayer);
    mysql_query($query);

    // increment played games for this player
    $query = sprintf("UPDATE player 
                      SET played = played + 1 
                      WHERE id='%s'", 
                      $_SESSION['uid']);
    mysql_query($query);
}

?>

