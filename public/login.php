<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    $username = htmlentities($_POST['nick']);
    $password = $_POST['pwd'];

    include('../lib/connectDB.php');

    // get authentication details of player
    $query = sprintf("SELECT id, name, pw 
                      FROM player 
                      WHERE name='%s'", 
                      mysql_real_escape_string($username));
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);

    // check if user exists
    if (!$row) {
        errorpage($username);
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
            errorpage($username);
        }
    }
}
function errorpage($username) {
$BODY=<<<EOB
Sorry, {$username}, there seems to be an error with your authentication.</p>
<form class="login form" action="login.php" method="post">
    <div class="form-group">
        <label class="col-lg-1 control-label">
            Nickname: 
        </label>
        <div class="col-lg-11">
            <div class="col-lg-3"><input class="form-control" type="text" name="nick" /></div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-1 control-label">
            Passwort: 
        </label>
        
        <div class="col-lg-11">
            <div class="col-lg-3"><input class="form-control" type="password" name="pwd" /></div>
        </div>
    </div>
    <div class="form-group"> 
        <div class="col-lg-11 col-lg-offset-1">
        <div class="col-lg-3"><input class="btn btn-primary btn-lg btn-block" type="submit" value="Login" /></div>
        </div>
    </div>
</form>
EOB;
include('../lib/template/base.php');
}
?>

