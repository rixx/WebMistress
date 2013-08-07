<?php header('Content-Type: application/json');?>
<?php include('../../lib/auth.php'); ?>
<?php

include('../../lib/connectDB.php');

// get relevant data about the current game
$query = sprintf("SELECT spielfeld, finished, turn 
                  FROM game 
                  WHERE id='%s'",
                  $_SESSION['gameid']);
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);

//Necessary, because otherwise 'true' woud be transmitted instead of true
if ($row['finished'] == 'true') {
    echo '{"board": '.$row['spielfeld'].', "finished": true, "turn": '.$row['turn'].'}';
} else {
    echo '{"board": '.$row['spielfeld'].', "finished": false, "turn": '.$row['turn'].'}';
}
?>
