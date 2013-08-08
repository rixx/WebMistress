<?php include('../lib/auth.php');
    include('../lib/connectDB.php');

    // get all information about the running game
    $query = sprintf("SELECT game.name as gamename, game.player1, p1.name as p1name, p2.name as p2name, game.color1, game.color2, game.spielfeld, game.turn, game.finished
                      FROM game 
                          LEFT JOIN player p1 ON game.player1 = p1.id 
                          LEFT JOIN player p2 ON game.player2 = p2.id
                      WHERE game.id=%d",
                      $_SESSION['gameid']);
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    
    // find out whether the current player is player 1 or player 2
    $playernum = ($row['player1'] == $_SESSION['uid']) ? '1' : '2';
    $enemynum = ($playernum % 2) + 1;
    $username = $row['p'.$playernum.'name'];
    
    mysql_close();

    $HEAD= <<<EOD
    <script>
        gameState = {$row['spielfeld']};
    
        players = { player1:
                    { name: "{$row['p1name']}",
                      color: "{$row['color1']}" },
                    player2:
                    { name: "{$row['p2name']}",
                      color: "{$row['color2']}" } };
    
        gameName = "{$row['gamename']}";
        playernum = {$playernum};
        enemynum = {$enemynum};
        activePlayer = 0;
    </script>

    <script src="/scripts/game.js"></script>
EOD;

    $BODY= <<<EOB
    <h4 id="playerStatus" class="playerStatus">{$row['p'.$playernum.'name']}</h4>
    <h4 id="enemyStatus" class="playerStatus" >{$row['p'.$enemynum.'name']}</h4>
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
EOB;
    include('../lib/template/base.php');

?>
