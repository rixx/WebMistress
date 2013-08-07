<?php 
if(!isset($_SESSION['login']) || !$_SESSION['login']) {
    include('../lib/connectDB.php');
    session_start();
    
    // Get the playername
    $query = sprintf("SELECT name, played, won
                      FROM player
                      WHERE id='%s'",
                      $_SESSION['uid']);
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    $playername = $row['name'];
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

?>

<html>
<head>
    <link rel="stylesheet" href="/styles/style.css">
    <script src="/lib/jquery.js"></script>
    <script type="text/javascript">

       setInterval(function(){$("#gamelist").load("pollGamelist.php");}, 1000);

    </script>
    <title>Vier Gewinnt - Laufende Spiele</title>
</head>

<body>

    <a href="/logout.php">Logout</a>
    <p> Welcome, <?=$playername; ?>!</p>
    <p> You've played <?=$played?> games and won <?=$won?> of them (<?=$percentage?> %)</p>

    <a href="/startgame.php">Start new game</a><br />
    <ul id="gamelist"> </ul>

</body>
</html>
<?php } else {?>

<html>
<head></head>
<body>
    <p><a href="login.php">Login</a></p>
    <p><a href="register.php">Register</a></p>
</body>
</html>
<?php } ?>
