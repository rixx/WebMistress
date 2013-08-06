<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    $username = $_POST['nick'];
    $password = $_POST['pwd'];

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

        $hashed_pw = crypt($password,'$6$rounds=5000$'.$username.'DHBW2013wasfuereinspass$');
        // check if password matches
        if ($hashed_pw == $row['pw']) {

            $_SESSION['login'] = true;
          //  $_SESSION['nick'] = $_POST['nick'];
            $_SESSION['uid'] = $row['id'];

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
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <form class="login" action="login.php" method="post">
        <label>Nickname: </label><input type="text" name="nick" /><br />
        <label>Passwort: </label><input type="password" name="pwd" /><br />
        <input type="submit" value="Login" />
    </form>
</body>
</html>

