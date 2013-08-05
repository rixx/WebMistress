<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    $username = $_POST['nick'];
    $passwort = $_POST['pwd'];

    include('connectDB.php');

    // get authentication details of player
    $query = sprintf("SELECT id, name, pw 
                      FROM player 
                      WHERE name='%s'", 
                      mysql_real_escape_string($_POST['nick']));
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);

    // check if user exists
    if (!$row) {
        echo "Sorry, ".$_POST['nick'].", there seems to be an error with your authentication.";
    } else {

        // check if password matches
        if ($_POST['pwd'] == $row['pw']) {

           $_SESSION['login'] = true;
           $_SESSION['nick'] = $_POST['nick'];

            header('Location: viergewinnt.php');
            mysql_close($link);
        } else {
            echo "Sorry, ".$_POST['nick'].", there seems to be an error with your authentication.";
        }
    }
}
?>

<html>
<head>
    <title>Vier Gewinnt - Login</title>
</head>
<body>
    <form action="login.php" method="post">
        Nickname: <input type="text" name="nick" /><br />
        Passwort: <input type="password" name="pwd" /><br />
        <input type="submit" value="Login" />
    </form>
</body>
</html>

