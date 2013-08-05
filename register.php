<html>
<head>
    <title>Vier Gewinnt - Login</title>
</head>
<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        session_start();
    
        $username = $_POST['nick'];
        $passwort = $_POST['pwd'];
        $passwort2 = $_POST['pwd2'];
        $mail = $_POST['mail'];
    
        include('connectDB.php');
    
        // check if passwords are ok
        if ($passwort != $passwort2) {
           echo "passwords do not match";
        } else {
    
            // check if the nick is already taken        
            $query = sprintf("SELECT id 
                              FROM user 
                              WHERE name='%s'", 
                              $username);
            $result = mysql_query($query);
            $row = mysql_fetch_assoc($result);
    
            if ($row) {
                echo "please choose a different username";
            } else {
    
                // register player
                $query = sprintf("INSERT INTO player (name, pw) VALUES ('%s','%s')",
                                  mysql_real_escape_string($username),
                                  mysql_real_escape_string($passwort));
                mysql_query($query);
    
                echo "Success! Wooo! Click <a href=\"login.php\">here</a> to log in!";
            }
        }
    }
    ?>

    <form action="register.php" method="post">
        Nickname: <input type="text" name="nick" /><br />
        Mail (optional): <input type="text" name="mail" /><br />
        Passwort: <input type="password" name="pwd" /><br />
        Passwort (repeat): <input type="password" name="pwd2" /><br />
        <input type="submit" value="Register!" />
    </form>
</body>
</html>

