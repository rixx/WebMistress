
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
    

    test_win($spielfeld, $column, $i);
    header('Location: game.php');


function test_win($spielfeld, $column, $row) {

    test_vertical($spielfeld, $column, $row);
    test_horizontal($spielfeld, $column, $row);
    test_diagonal_left($spielfeld, $column, $row);
    test_diagonal_right($spielfeld, $column, $row);
}

function test_vertical($spielfeld, $column, $row) {

    $vertical = 1;
    global $value;

    if ($row <= 2) {
        $j = $row+1;

        while ($vertical > 0 && $vertical < 4) {
            if ((int)$spielfeld[$j][$column] == $value) {
                $vertical++;
                $j++;
            } else {
                $vertical = 0;
            }
        }

        if ($vertical = 4) {
            win();
        }
    }
}

function test_horizontal($spielfeld, $column, $row) {
    $horizontal = 1; 
    $c = $column - 1;
    global $value;

    while ($c >= 0) {
        if ((int)$spielfeld[$row][$c] == $value) {
            $horizontal++;
        } else {
            break;
        }
        $c--;
    }

    $c = $column + 1;

    while ($c < 7) {

        if ((int)$spielfeld[$row][$c] == $value) {
            $horizontal++;
        } else {
            break;
        }
        $c++;
    }

    if ($horizontal >= 4) {
        win();
    }
}

function test_diagonal_left($spielfeld, $column, $row) {
        
    $diagonal_left = 1;
    global $value;
    $c = $column -1;
    $r = $row - 1;

    while ($c >= 0 && $r >= 0) {
        if ((int)$spielfeld[$r][$c] == $value) {
            $diagonal_left++;
            $c--;
            $r--;
        }else break;
    }

    $c = $column + 1;
    $r = $row + 1;
    while ($c < 7 && $r < 6) {
        if ((int)$spielfeld[$r][$c] == $value)  {
            $diagonal_left++;
            $c++;
            $r++;
        } else break;
    }

    if ($diagonal_left >= 4) {
        win();
    }
}


function test_diagonal_right($spielfeld, $column, $row) {
    
    $diagonal_right = 1;
    global $value;
    $c = $column + 1;
    $r = $row - 1;

    while ($c >= 0 && $r >= 0) {
        if ((int)$spielfeld[$r][$c] == $value) {
            $diagonal_right++;
            $c++;
            $r--;
        }else break;
    }

    $c = $column - 1;
    $r = $row + 1;
    while ($c < 7 && $r < 6) {
        if ((int)$spielfeld[$r][$c] == $value)  {
            $diagonal_right++;
            $c--;
            $r++;
        } else break;
    }

    if ($diagonal_right >= 4) {
        win();
    }

}


function win() {

    $query = sprintf("update game set finished='true' where id='%s'",$_SESSION['gameid']);
    mysql_query($query);

    header('Location: game.php');
    exit();
}


?>

