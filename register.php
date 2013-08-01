<?php
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         session_start();

         //check if username exists
         //check if pwd is ok
         //register

         $username = $_POST['nick'];
         $passwort = $_POST['pwd'];
         $passwort2 = $_POST['pwd2'];
         $mail = $_POST['mail'];
 
         $link = mysql_connect('127.0.0.1', 'rix', 'blakeks');
 
         if (!$link) {
             echo htmlspecialchars('nope');
             die('Verbindung schlug fehl: ' . mysql_error());
         }
 
         $db = mysql_select_db("viergewinnt",$link);
 
         if ($passwort != $passwort2) {
            echo "passwords do not match";
         } else {

            $query = sprintf("select id from user where name='%s'",$username);
            $result = mysql_query($query);
            $row = mysql_fetch_assoc($result);

            if ($row) {
                echo "please choose a different username";
            } else {

                $query = sprintf("insert into player (name, pw) values ('%s','%s')",
                                    mysql_real_escape_string($username),
                                    mysql_real_escape_string($passwort));
                mysql_query($query);

                echo "Success! Wooo! Click <a href=\"login.php\">here</a> to log in!";
            }
        }
     }
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
 <head>
  <title>Vier Gewinnt - Login</title>
 </head>
 <body>
  <form action="register.php" method="post">
   Nickname: <input type="text" name="nick" /><br />
   Mail (optional): <input type="text" name="mail" /><br />
   Passwort: <input type="password" name="pwd" /><br />
   Passwort (repeat): <input type="password" name="pwd2" /><br />
   <input type="submit" value="Register!" />
  </form>
 </body>
</html>

