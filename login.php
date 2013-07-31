Hi <?php echo htmlspecialchars($_POST['nick']); ?>.<p />


<?php
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         session_start();

        $username = $_POST['nick'];
         $passwort = $_POST['pwd'];

         $hostname = $_SERVER['HTTP_HOST'];
         $path = dirname($_SERVER['PHP_SELF']);

 
         $link = mysql_connect('127.0.0.1', 'rix', 'blakeks');
 
         if (!$link) {
             echo htmlspecialchars('nope');
             die('Verbindung schlug fehl: ' . mysql_error());
         }
 
         $db = mysql_select_db("viergewinnt",$link);
 
         $query = sprintf("SELECT id, name, pw FROM player WHERE name='%s'", mysql_real_escape_string($_POST['nick']));
         $result = mysql_query($query);
         $row = mysql_fetch_assoc($result);
 
 
         if (!$row) {
             echo "Sorry, ".$_POST['nick'].", you don't seem to be registered.";
         } else {
             echo "Hi, ".$_POST['nick'].", your ID is ".$row['id'].".";

             if ($_POST['pwd'] == $row['pw']) {
 
                $_SESSION['login'] = true;
                $_SESSION['nick'] = $_POST['nick'];
                
  
                if ($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1') {
                     if (php_sapi_name() == 'cgi') {
                         header('Status: 303 See Other');
                    }
                    else {
                         header('HTTP/1.1 303 See Other');
                    }
                }
             header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/viergewinnt.php');
             mysql_close($link);
             exit;
             } else {
                 echo "Wrong password";
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
  <form action="login.php" method="post">
   Nickname: <input type="text" name="nick" /><br />
   Passwort: <input type="password" name="pwd" /><br />
   <input type="submit" value="Login" />
  </form>
 </body>
</html>

