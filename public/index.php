<?php
session_start();
if(isset($_SESSION['login']) && $_SESSION['login']) {
    include('../lib/connectDB.php');
    
    // Get the playername
    $query = sprintf("SELECT name, played, won
                      FROM player
                      WHERE id='%s'",
                      $_SESSION['uid']);
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    $username = $row['name'];
    $won = $row['won'];
    $played = $row['played'];
    $percentage = ($played == 0) ? 0 : round(($won/$played)*100);

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


$HEAD=<<<EOH
    <script type="text/javascript">
       setInterval(function() {\$ ("#gamelist").load("/api/pollGamelist.php"); }, 1000);
    </script>
EOH;

$BODY=<<<EOB
    <p> Welcome, {$username}!</p>
    <p> You've played {$played} games and won {$won} of them ({$percentage} %)</p>

    <a href="/startgame.php">Start new game</a><br />
    <ul id="gamelist"> </ul>
EOB;
} else {
$BODY=<<<EOB
Weeee! <br>This is a project for the Web Engineering course at DHBW Stuttgart 2013. The goal was to implement the game Captain's Mistress using only php, javascript with jQuery and a MySQL database. The current version is hosted at http://viergewinnt.foyfoy.de/.
<hr>

Dies ist ein Projekt des Web-Engineering-Kurses an der DHBW Stuttgart 2013. Das Ziel war es, das Spiel "Vier gewinnt" mithilfe von php, javascript mit jQuery und einer MySQL-Datenbank zu implementieren.

EOB;
}
include('../lib/template/base.php');

?>

