<?php
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         session_start();

         $gamename = $_POST['name'];
 
         $link = mysql_connect('127.0.0.1', 'rix', 'blakeks');
 
         if (!$link) {
             echo htmlspecialchars('nope');
             die('Verbindung schlug fehl: ' . mysql_error());
         }
 
         $db = mysql_select_db("viergewinnt",$link);

         $query = sprintf("select id from player where name='%s'",$_SESSION['nick']);
         $result = mysql_query($query);
         $row = mysql_fetch_assoc($result);


         $query = sprintf("insert into game (name, player1) values ('%s','%s')",
                            $gamename, $row['id']);
         mysql_query($query);
         $_SESSION['gameid'] = mysql_insert_id();

         header('Location: game.php');
    }
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
 <head>
  <title>Vier Gewinnt - Login</title>
 </head>
 <body>
  <form action="startgame.php" method="post">
   Game name: <input type="text" name="name" /><br />
   <input type="submit" value="Start" />
  </form>
 </body>
</html>

