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
         include('exitRemaining.php');

         $query = sprintf("select id from player where name='%s'",$_SESSION['nick']);
         $result = mysql_query($query);
         $row = mysql_fetch_assoc($result);

         $colors = explode('_',$_GET['colors']);

         $query = sprintf("insert into game (name, player1, color1, color2) values ('%s','%s','%s','%s')",
                            $gamename, $row['id'],$colors[0],$colors[1]);
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
   Color combination: 
    <select name="colors">
        <option value="red_yellow" selected>Red/Yellow</option>
        <option value="red_black" selected>Red/Black</option>
        <option value="grey_black" selected>Grey/Black</option>
        <option value="black_grey" selected>Black/Grey</option>
    </select>
   <input type="submit" value="Start" />
  </form>
 </body>
</html>

