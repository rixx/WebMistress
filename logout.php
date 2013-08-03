<?php
    session_start();
    
    $link = mysql_connect('127.0.0.1', 'rix', 'blakeks');
 
    if (!$link) {
        echo htmlspecialchars('nope');
        die('Verbindung schlug fehl: ' . mysql_error());
    }
 
    $db = mysql_select_db("viergewinnt",$link);
    
    $query = sprintf("select game.id, p1.name as p1name, p2.name as p2name
                      from game left join player p1 on game.player1=p1.id 
                          left join player p2 on game.player2=p2.id 
                      where game.finished='false' 
                          and (p1.name='%s' or p2.name='%s')",
                      $_SESSION['nick'],$_SESSION['nick']);

    $otherplayer = ($row['p1name'] == $_SESSION['nick']) ? $row['p2name'] : $row['p1name'];
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);


    if ($row) {
        $query = sprintf("update game set finished='true' where id='%s'",$row['id']);
        mysql_query($query);
        $query = sprintf("update player set won = won + 1, played = played + 1 where name = '%s'",$otherplayer);
        mysql_query($query);
        $query = sprintf("update player set played = played + 1 where name='%s'", $_SESSION['nick']);
        mysql_query($query);
    }

    session_destroy();

    $hostname = $_SERVER['HTTP_HOST'];
    $path = dirname($_SERVER['PHP_SELF']);
    header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/login.php');
?>
