<?php include('auth.php'); ?>
<html>

<head>
<meta http-equiv="refresh" content="3">
</head>


<body>

<table border="0" cellspacing="0" cellpadding="0">


<?php
$colorarr=array("red","blue","green","yellow","white","black");

session_start();

$link = mysql_connect('127.0.0.1', 'rix', 'blakeks');

if (!$link) {
echo htmlspecialchars('nope');
die('Verbindung schlug fehl: ' . mysql_error());
}

$db = mysql_select_db("viergewinnt",$link);

$query = sprintf("select game.name as gamename, p1.name as p1name, p2.name as p2name, game.color1, game.color2, game.spielfeld, game.turn, game.finished
              from game left join player p1 on game.player1 = p1.id 
                left join player p2 on game.player2 = p2.id
              where game.id='%s'",$_SESSION['gameid']);
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);

$playernum = ($row['p1name'] == $_SESSION['nick']) ? '1' : '2';

if ($row['finished'] == 'true') {

if ($playernum == $row['turn']) {
    echo "you lost";
} else {
    echo "you WIN";
}
} else {

    $spielfeld = json_decode($row['spielfeld']);
    $colors = array("white",$row['color1'],$row['color2']);


    for ($i = 0; $i < 6; $i++) {
        echo "<tr height=\"80\">";
        for ($j = 0; $j < 7; $j++) {
            echo "<td width=\"80\" bgcolor=\"".$colors[(int)$spielfeld[$i][$j]]."\">";
            
            if ($playernum == $row['turn']) {
                echo "<a href=\"turn.php?column=". $j . "\"><img src=\"4g.png\"></a></td>";
            } else {
                echo "<img src=\"4g.png\"/></td>";
            }
        }
        echo "</tr>";
    }
}

mysql_close();

?>
</table> 



</body>
</html>
