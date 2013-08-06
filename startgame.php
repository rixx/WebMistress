<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    session_start();
    include('connectDB.php');
    include('exitRemaining.php');

    $gamename = htmlentities($_POST['name']);

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

    header('Location: game.php');
}
?>

<html>
<head>
    <title>Vier Gewinnt - Login</title>
</head>
<body>
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
</body>
</html>

