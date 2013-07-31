<?php include('auth.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
 <head>
  <title>Vier Gewinnt - Choose your game!</title>
 </head>
 <body>

<a href="logout.php">Logout</a>

<p> Welcome, <?php session_start(); echo $_SESSION['nick']; ?>!</p>

<?php

    session_start();
    
    $link = mysql_connect('127.0.0.1', 'rix', 'blakeks');

    if (!$link) {
        echo htmlspecialchars('nope');
        die('Verbindung schlug fehl: ' . mysql_error());
    }

    $db = mysql_select_db("viergewinnt",$link);

    $query = sprintf("select game.id, game.name as gamename, p1.name as p1name, p2.name as p2name 
                      from game left join player p1 on game.player1=p1.id 
                          left join player p2 on game.player2=p2.id 
                      where game.finished='false' 
                          and (p1.name='%s' or p2.name='%s')",
                      $_SESSION['nick'],$_SESSION['nick']);

    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);


    if ($row) {
       echo "You are already involved in a running game (";
       echo $row['gamename'];
       $_SESSION['gameid'] = $row['id'];
       echo "). Redirecting …";
       header('Location: game.php');

    } else {
        $query = sprintf("select game.name as gamename, p1.name as p1name, p2.name as p2name
                      from game left join player p1 on game.player1=p1.id 
                          left join player p2 on game.player2=p2.id 
                      where game.finished='false'
                          and (p1.name is null xor p2.name is null)");
        $result = mysql_query($query);

        echo "Running games:<br>";

        while ($row = mysql_fetch_assoc($result)) {
            
            echo $row['gamename']." (".$row['p1name'].$row['p2name'].")<br>";

        }

    }

   ?>

 </body>
</html>
