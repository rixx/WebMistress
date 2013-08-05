<?php include('auth.php'); ?>
<html>
<head>
    <title>Vier Gewinnt - Choose your game!</title>
</head>

<body>

<?php
    include('connectDB.php');
    
    $query = sprintf("SELECT name
                      FROM player
                      WHERE id='%s'",
                      $_SESSION['uid']);
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    $playername = $row['name'];
?>

<a href="logout.php">Logout</a>
<p> Welcome, <?=$playername; ?>!</p>

<?php

    // Look for unfinished games the current player is involved in
    $query = sprintf("SELECT id 
                      FROM game 
                      WHERE game.finished='false' 
                          AND (player1='%s' or player2='%s')",
                      $_SESSION['uid'], $_SESSION['uid']);
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    
    // If there is such a game, redirect
    if ($row) {
       $_SESSION['gameid'] = $row['id'];
       header('Location: game.php');
    } 

    echo "<a href=\"startgame.php\">Start new game</a><br />";

    // Look for games without a second player
    $query = sprintf("SELECT game.id, game.name AS gamename, player.name AS player1name
                      FROM game 
                          JOIN player ON game.player1=player.id 
                      WHERE game.finished='false'
                          AND game.player2 IS NULL");
    $result = mysql_query($query);
    
    echo "Running games:<br>";
    
    while ($row = mysql_fetch_assoc($result)) {
        echo "<a href=\"join.php?id=".$row['id']."\">".$row['gamename']." (".$row['player1name'].")</a><br>";
    }
?>

</body>
</html>
