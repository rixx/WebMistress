<?php include('auth.php'); ?>
<?php

session_start();

include('connectDB.php');

// get player names and ids from the running game
$query = sprintf("SELECT p1.name AS p1name, p2.name AS p2name, game.finished
                  FROM game 
                      LEFT JOIN player p1 ON game.player1 = p1.id 
                      LEFT JOIN player p2 ON game.player2 = p2.id
                  WHERE game.id='%s'",
                  $_SESSION['gameid']);
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);

if ($row['finished'] == 'false') {
    $playernum = ($row['p1name'] == $_SESSION['nick']) ? '1' : '2';
    
    // set winner to the other player
    if ($_SESSION['nick'] == $row['p1name']) {
        $winner = $row['p2name'];
    } else {
        $winner = $row['p1name'];
    }
    
    $loser = $_SESSION['nick'];
    
    // increment won and played games for the winner
    $query = sprintf("UPDATE player 
                      SET played = played + 1, won = won + 1
                      WHERE name='%s'",
                      $winner);
    mysql_query($query);
    
    //increment played games for the loser
    $query = sprintf("UPDATE player 
                      SET played = played + 1 
                      WHERE name='%s'",
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
