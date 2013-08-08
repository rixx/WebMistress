<?php 
include('../lib/auth.php');
include('../lib/connectDB.php');
include('../lib/exitRemaining.php');

$query = sprintf("SELECT player2 
                  FROM game 
                  WHERE id=%d",
                  mysql_real_escape_string($_GET['id']));
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);

// check if a second player exists already
if (!empty($row['player2'])) {
    echo "Sorry, das Spiel ist schon voll.";
} else {

    $_SESSION['gameid'] = (int)($_GET['id']);

    // otherwise, set the second player and redirect 
    $query = sprintf("UPDATE game 
                      SET player2=%d
                      WHERE game.id=%d", 
                      $_SESSION['uid'], $_SESSION['gameid']);
    mysql_query($query);
    header("HTTP/1.1 303 See Other");
    header('Location: game.php');
}

?>


