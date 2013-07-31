
<?php include('auth.php'); ?>

<?php

session_start();

$link = mysql_connect('127.0.0.1', 'rix', 'blakeks');

if (!$link) {
    echo htmlspecialchars('nope');
    die('Verbindung schlug fehl: ' . mysql_error());
}

    $db = mysql_select_db("viergewinnt",$link);
    
    $query = sprintf("select p1.name as p1name, p2.name as p2name, game.spielfeld
                      from game left join player p1 on game.player1 = p1.id 
                        left join player p2 on game.player2 = p2.id
                      where game.id='%s'",$_SESSION['gameid']);
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    
    $spielfeld = json_decode($row['spielfeld']);
    
    $column = (int)$_GET['column'];
    
    $i = 5;

    while ($i >= 0) {
        
        if (0 == (int)$spielfeld[$i][$column]) {
            break;
        } 

        $i--;

    }

    if ($i >= 0) {

        if ($row['p1name'] == $_SESSION['nick']) {
            $spielfeld[$i][$column] = 1;
            $turn = '2';

        } else if ($row['p2name'] = $_SESSION['nick']) {
            $spielfeld[$i][$column] = 2;
            $turn = '1';
        }

        $query = sprintf("update game set spielfeld = '%s', turn='%s' where id='%s'", json_encode($spielfeld),$turn,$_SESSION['gameid']);
        mysql_query($query);
       
    }

    header('Location: game.php');
?>

