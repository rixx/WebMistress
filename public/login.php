<?php
$BODY;
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
            $_SESSION['uid'] = $row['id'];

            header('Location: index.php');
            mysql_close($link);
        } else {
            errorpage($username);
        }
    }
} else {
    getLoginPage();
}

function errorpage($username) {
    global $BODY;
    $BODY ="<div class=\"alert alert-danger\">Sorry, ".htmlentities($username).", there seems to be an error with your authentication. Are you sure that you are <a href=\"/register.php\" class=\"alert-link\">registered</a>?</div>";
    getLoginPage();
}

function getLoginPage() {
    global $BODY;
    $BODY.=<<<EOB
<form class="login form-horizontal" action="login.php" method="post">
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

