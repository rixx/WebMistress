<?php include('auth.php'); ?>
<?php

    include('connectDB.php');

    // get all information about the running game
    $query = sprintf("SELECT game.name as gamename, p1.name as p1name, p2.name as p2name, game.color1, game.color2, game.spielfeld, game.turn, game.finished
                      FROM game 
                          LEFT JOIN player p1 ON game.player1 = p1.id 
                          LEFT JOIN player p2 ON game.player2 = p2.id
                      WHERE game.id='%s'",
                      $_SESSION['gameid']);
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    
    // find out whether the current player is player 1 or player 2
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
