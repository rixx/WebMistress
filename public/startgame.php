<?php

include('../lib/auth.php');
include('../lib/connectDB.php');
include('../lib/exitRemaining.php');
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $gamename = htmlentities($_POST['name']);

    if (strlen($gamename) < 3) {
        echo "Sorry, your chosen game name seems to be too short.";
    } else {
        // gets the selected color combination
        $colors = explode("_",$_POST['colors']);
    
        // generates the new game
        $query = sprintf("INSERT INTO game (name, player1, color1, color2) 
                          VALUES ('%s','%s','%s','%s')",
                          mysql_real_escape_string($gamename), 
                          $_SESSION['uid'],
                          mysql_real_escape_string(htmlentities($colors[0])),
                          mysql_real_escape_string(htmlentities($colors[1])));
        mysql_query($query);
    
        $_SESSION['gameid'] = mysql_insert_id();
        header("HTTP/1.1 303 See Other"); 
        header('Location: game.php');
    }
} else {
    $query = sprintf("SELECT name
                      FROM player
                      WHERE id=%d",
                      $_SESSION['uid']);
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);

    $username = $row['name'];
}


$BODY=<<<EOB
    
   <form action="startgame.php" method="post">
        Game name: <input type="text" name="name" /><br />
        Color combination: 
        <select name="colors">
            <option value="red_yellow" selected>Red/Yellow</option>
            <option value="red_black">Red/Black</option>
            <option value="grey_black">Grey/Black</option>
            <option value="black_grey">Black/Grey</option>
        </select>
        <input type="submit" value="Start" />
    </form>
EOB;

include('../lib/template/base.php');
?>
