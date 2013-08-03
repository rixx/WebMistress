<?php include('auth.php'); ?>

<?php

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
$enemynum = ($playernum % 2) + 1;

mysql_close();

?>
<html>

<head>
<link rel="stylesheet" href="style.css">
<script src="jquery.js"></script>
<script>

    gameState = <?=$row['spielfeld'] ?>;

    players = { player1:
                { name: "<?=$row['p1name']?>",
                  color: "<?=$row['color1']?>" },
                player2:
                { name: "<?=$row['p2name']?>",
                  color: "<?=$row['color2']?>" } };

    gameName = "<?=$row['gamename']?>";
    playernum = <?=$playernum?>;
    enemynum = <?=$enemynum?>;
    activePlayer = 0;
                 

</script>
<script src="game.js"></script>
</head>


<body>

<h4 id="playerStatus" class="playerStatus"><?=$_SESSION['nick']?></h4>
<h4 id="enemyStatus" class="playerStatus" ><?=$row['p'.$enemynum.'name']?></h4>
<h4 id="gameStatus"></h4>

<svg height="480" width="560">

    <defs>
        <mask id="token-holes">
            <rect width="560" height="480" fill="white" />
        </mask>
    </defs>
   <g id="tokens">

   </g>

   <g id="board">
        <rect width="560" height="480" fill="blue" mask="url(#token-holes)" />

    </g>


</svg>
<div id="links">
<a href="giveup.php">I give up!</a><br />
<a href="logout.php">Get me out of here!</a>
</div>
</body>
</html>
