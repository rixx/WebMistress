<?php

// all games in which the current player is involved, are marked as finished
// this prevents players from playing multiple games simultaniously
$query = sprintf("SELECT game.id, p1.name as p1name, p2.name as p2name
                  FROM game 
                    LEFT JOIN player p1 ON game.player1=p1.id 
                    LEFT JOIN player p2 ON game.player2=p2.id 
                  WHERE game.finished='false' 
                    AND (p1.name='%1s' or p2.name='%1s')",
                  $_SESSION['nick']);

$result = mysql_query($query);

while ($row = mysql_fetch_assoc($result)) {

    // find enemy
    $otherplayer = ($row['p1name'] == $_SESSION['nick']) ? $row['p2name'] : $row['p1name'];

    // set the game to finished
    $query = sprintf("UPDATE game SET finished='true' WHERE id='%s'",$row['id']);
    mysql_query($query);

    // increment won and played games for the other player
    $query = sprintf("UPDATE player 
                      SET won = won + 1, played = played + 1 
                      WHERE name = '%s'",
                      $otherplayer);
    mysql_query($query);

    // increment played games for this player
    $query = sprintf("UPDATE player 
                      SET played = played + 1 
                      WHERE name='%s'", 
                      $_SESSION['nick']);
    mysql_query($query);
}

?>

