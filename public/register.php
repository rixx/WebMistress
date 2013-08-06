<html>
<head>
    <title>Vier Gewinnt - Register</title>
    <link rel="stylesheet" href="/styles/style.css" />
</head>
<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        session_start();
    
        $username = $_POST['nick'];
        $password = $_POST['pwd'];
        $password2 = $_POST['pwd2'];
        $mail = $_POST['mail'];
    
        include('../lib/connectDB.php');
    
        if (strlen($username) < 3 || strlen($password) < 3) {
            echo "Username or Password too short.";
        // check if passwords are ok
        } else if ($password != $password2) {
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
    
                $hashed_pw = crypt($password,'$6$rounds=5000$'.$username.'DHBW2013wasfuereinspass$');
                // register player
                $query = sprintf("INSERT INTO player (name, pw) VALUES ('%s','%s')",
                                  mysql_real_escape_string(htmlentities($username)),
                                  mysql_real_escape_string(htmlentities($hashed_pw)));
                mysql_query($query);
    
                echo "Success! Wooo! Click <a href=\"/login.php\">here</a> to log in!";
            }
        }
    }
    ?>

    <form class="register" action="/register.php" method="post">
        <label>Nickname: </label><input type="text" name="nick" /><br />
        <label>Mail (optional): </label><input type="text" name="mail" /><br />
        <label>Passwort: </label><input type="password" name="pwd" /><br />
        <label>Passwort (repeat): </label><input type="password" name="pwd2" /><br />
        <input type="submit" value="Register!" />
    </form>
</body>
</html>

