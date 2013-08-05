<?php include('auth.php'); ?>
<?php

session_start();

include('connectDB.php');

// get player names and ids from the running game
$query = sprintf("SELECT player1, player2, finished
                  FROM game 
                  WHERE game.id='%s'",
                  $_SESSION['gameid']);
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);

if ($row['finished'] == 'false') {
    $playernum = ($row['player1'] == $_SESSION['uid']) ? '1' : '2';
    
    // set winner to the other player
    $winner = ($_SESSION['uid'] == $row['player1']) ? $row['player2'] : $row['player1'];
    $loser = $_SESSION['uid'];
    
    // increment won and played games for the winner
    $query = sprintf("UPDATE player 
                      SET played = played + 1, won = won + 1
                      WHERE id='%s'",
                      $winner);
    mysql_query($query);
    
    //increment played games for the loser
    $query = sprintf("UPDATE player 
                      SET played = played + 1 
                      WHERE id='%s'",
                      $loser);
    mysql_query($query);
    
    $query = sprintf("UPDATE game 
                      SET finished='true', turn='%s' 
                      WHERE id='%s'",
                      $playernum,$_SESSION['gameid']);
    mysql_query($query);
}

mysql_close($link);
include('exitRemaining.php');
header('Location: viergewinnt.php');

?>
