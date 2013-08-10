<?php 
header('Content-Type: application/json');
include('../../lib/auth.php'); 
include('../../lib/connectDB.php');

// get relevant data about the current game
$query = sprintf("SELECT spielfeld, finished, turn 
                  FROM game 
                  WHERE id='%s'",
                  $_SESSION['gameid']);
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);

echo '{"board": '.$row['spielfeld'].', "finished": "'.$row['finished'].'", "turn": '.$row['turn'].'}';
?>
