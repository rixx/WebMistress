<?php

session_start();

$link = mysql_connect('127.0.0.1', 'rix', 'blakeks');

if (!$link) {
echo htmlspecialchars('nope');
die('Verbindung schlug fehl: ' . mysql_error());
}

$db = mysql_select_db("viergewinnt",$link);

$query = sprintf("select p1.name as p1name, p2.name as p2name
              from game left join player p1 on game.player1 = p1.id 
                left join player p2 on game.player2 = p2.id
              where game.id='%s'",$_SESSION['gameid']);
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);

$playernum = ($row['p1name'] == $_SESSION['nick']) ? '1' : '2';

if ($_SESSION['nick'] == $row['p1name']) {

    $winner = $row['p2name'];
} else {
    $winner = $row['p1name'];
}

$loser = $_SESSION['nick'];

$query = sprintf("update player set played = played + 1, won = won + 1
                    where name='%s'",$winner);
mysql_query($query);

$query = sprintf("update player set played = played + 1 where name='%s'",$loser);
mysql_query($query);

$query = sprintf("update game set finished='true', turn='%s' where id='%s'",$playernum,$_SESSION['gameid']);
mysql_query($query);

mysql_close($link);
include('exitRemaining.php');
header('Location: viergewinnt.php');


