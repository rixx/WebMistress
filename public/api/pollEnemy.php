<?php header('Content-Type: application/json');?>
<?php include('../../lib/auth.php'); ?>
<?php

include('../../lib/connectDB.php');

// gets the second player
$query = sprintf("SELECT game.player2, player.name 
                  FROM game 
                      LEFT JOIN player ON game.player2=player.id
                  WHERE game.id=%d", 
                  $_SESSION['gameid']);
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);

// if a second player is set, his name is returned, otherwise an error is sent
if (!empty($row['player2'])) {
    echo '{"enemy": "'.$row['name'].'"}';
} else {
    echo '{"error": "no enemy defined"}';
}

?>
