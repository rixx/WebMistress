<?php include('auth.php'); ?>
<?php

include('connectDB.php');
include('exitRemaining.php');

$query = sprintf("SELECT player2 
                  FROM game 
                  WHERE id='%s'",
                  mysql_real_escape_string($_GET['id']));
                  error_log("ID: ".$_GET['id']);
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);

// check if a second player exists already
if (!empty($row['player2'])) {
    echo "Sorry, das Spiel ist schon voll.";
} else {

    $_SESSION['gameid'] = mysql_real_escape_string($_GET['id']);

    // otherwise, set the second player and redirect 
    $query = sprintf("UPDATE game 
                      SET player2='%s'
                      WHERE game.id='%s'", 
                      $_SESSION['uid'], $_SESSION['gameid']);
    mysql_query($query);

    header('Location: game.php');
}

?>


