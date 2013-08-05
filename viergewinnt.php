<?php include('auth.php'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
    <title>Vier Gewinnt - Choose your game!</title>
</head>

<body>

<a href="logout.php">Logout</a>
<p> Welcome, <?php session_start(); echo $_SESSION['nick']; ?>!</p>

<?php

    session_start();
    include('connectDB.php');
    
    // Look for unfinished games the current player is involved in
    $query = sprintf("SELECT game.id 
                      FROM game 
                          LEFT JOIN player p1 ON game.player1=p1.id 
                          LEFT JOIN player p2 ON game.player2=p2.id 
                      WHERE game.finished='false' 
                          AND (p1.name='%s' OR p2.name='%s')",
                      mysql_real_escape_string($_SESSION['nick']),
                      mysql_real_escape_string($_SESSION['nick']));
                      echo $query;
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
