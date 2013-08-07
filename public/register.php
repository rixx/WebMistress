<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    $username = $_POST['nick'];
    $password = $_POST['pwd'];
    $password2 = $_POST['pwd2'];
    $mail = $_POST['mail'];

    include('../lib/connectDB.php');

    if (strlen($username) < 3 || strlen($password) < 3) {
        $errorMessage = "Username or Password too short.";
    // check if passwords are ok
    } else if ($password != $password2) {
        $errorMessage = "Passwords do not match.";
    } else {

        // check if the nick is already taken        
        $query = sprintf("SELECT id 
                          FROM user 
                          WHERE name='%s'", 
                          $username);
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);

        if ($row) {
            $errorMessage = "Please choose a different Username.";
        } else {

            $hashed_pw = crypt($password,'$6$rounds=5000$'.$username.'DHBW2013wasfuereinspass$');
            // register player
            $query = sprintf("INSERT INTO player (name, pw, mail) VALUES ('%s','%s', '%s')",
                              mysql_real_escape_string(htmlentities($username)),
                              mysql_real_escape_string(htmlentities($hashed_pw)),
                              mysql_real_escape_string($mail));
            mysql_query($query);

            $successMessage = "Success! Wooo! Click <a href=\"/login.php\" class=\"alert-link\">here</a> to log in!";
        }
    }
}
$BODY;
if (isset($errorMessage)) {
    $BODY = "<div class=\"alert alert-danger\">".$errorMessage."</div>";
} else if (isset($successMessage)) {
    $BODY = "<div class=\"alert alert-success\">".$successMessage."</div>";
}
$BODY .=<<<EOB
<form class="register form-horizontal" action="/register.php" method="post">
    <div class="form-group">
        <label class="col-lg-2 control-label">
            Nickname: 
        </label>
        <div class="col-lg-10">
            <div class="col-lg-3"><input class="form-control" type="text" name="nick" /></div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">
            Mail: 
        </label>
        <div class="col-lg-10">
            <div class="col-lg-3"><input class="form-control" type="text" name="mail" /></div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">
            Passwort: 
        </label>
        
        <div class="col-lg-10">
            <div class="col-lg-3"><input class="form-control" type="password" name="pwd" /></div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">
            Passwort (repeat): 
        </label>
        
        <div class="col-lg-10">
            <div class="col-lg-3"><input class="form-control" type="password" name="pwd2" /></div>
        </div>
    </div>
    <div class="form-group"> 
        <div class="col-lg-10 col-lg-offset-2">
        <div class="col-lg-3"><input class="btn btn-primary btn-lg btn-block" type="submit" value="Register" /></div>
        </div>
    </div>
</form>
EOB;

include('../lib/template/base.php');
?>
