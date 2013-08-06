<?php header('Content-Type: text/html');?>
<?php include('auth.php'); ?>
<?php

include('connectDB.php');

// get list of all games with only one player
$query = sprintf("SELECT game.id, game.name AS gamename, player.name AS player1name
                  FROM game
                      JOIN player on game.player1=player.id
                  WHERE game.player2 IS NULL AND game.finished='false'");
$result = mysql_query($query);

while ($row = mysql_fetch_assoc($result)) {
    echo "<li><a href=\"join.php?id=".$row['id']."\">".$row['gamename']." (".$row['player1name'].")</a></li>";
}

