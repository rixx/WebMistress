
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


    $bla = array_fill(0,5,array_fill(0,6,array_fill(0,4,0));    



    if ($i >= 0) {

        if ($row['p1name'] == $_SESSION['nick']) {
            $value = 1;
            $spielfeld[$i][$column] = $value;
            $turn = '2';

        } else if ($row['p2name'] = $_SESSION['nick']) {
            $value = 2;
            $spielfeld[$i][$column] = $value;
            $turn = '1';
        }

        $query = sprintf("update game set spielfeld = '%s', turn='%s' where id='%s'", json_encode($spielfeld),$turn,$_SESSION['gameid']);
        mysql_query($query);
       
    }


    $vertical = 1;
    $horizontal = 1;
    $diagonal_left = 1;
    $diagonal_right = 1;

    //test for vertical first, only go down
    if ($i <= 2) {
        $j = $i+1;
        while ($vertical > 0 && $vertical < 4) {
            if ((int)$spielfeld[$j][$column] == $value) {
                $vertical++;
            } else {
                $vertical = 0;
            }
        }

        if ($vertical = 4) {
            won();
        }
    }

    //test horizontal
    $c = $column - 1;

    while ($c >= 0) {
        if ((int)$spielfeld[$i][$c] == $value) {
            $horizontal++;
        } else {
            break;
        }
        $c--;
    }

    $c = $column + 1;

    while ($c < 7) {
        if ((int)$spielfeld[$i][$z] == $value) {
            $horizontal++;
        } else {
            break;
        }
        $c++;
    }

    if ($horizontal >= 4) {
        won()
    }

        

    header('Location: game.php');
?>

