<?php 
header('Content-Type: application/json');
include('../../lib/auth.php');
include('../../lib/connectDB.php');

// find out everything about the current game
$query = sprintf("SELECT player1, player2, spielfeld, finished, turn
                  FROM game 
                  WHERE id=%d",
                  $_SESSION['gameid']);
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$player1 = $row['player1'];
$player2 = $row['player2'];

// find out if the current player is player 1 or 2
$whoami = ($_SESSION['uid'] == $row['player1']) ? 1 : 2;

if ($row['finished'] == 'true') {
    echo '{"error": "Game is already over."}';
} else if ($whoami != $row['turn']) {
    echo '{"error": "Not your turn."}';
} else {

    $spielfeld = json_decode($row['spielfeld']);
    $column = (int)$_GET['column'];

    // find the right row for the new element 
    for ($i = 5; $i >= 0; $i--) {

        if (0 == (int)$spielfeld[$i][$column]) {
            break;
        } 
    }

    if ($i < 0) {
        echo '{"error": "Column is full"}';
    } else {

        if ($row['player1'] == $_SESSION['uid']) {
            $value = 1;
            $turn = '2';

        } else {
            $value = 2;
            $turn = '1';
        }

        $spielfeld[$i][$column] = $value;

        // insert the new board configuration and turn
        $query = sprintf("UPDATE game 
                          SET spielfeld = '%s', turn='%s' 
                          WHERE id=%d", 
                          json_encode($spielfeld), $turn, $_SESSION['gameid']);
        mysql_query($query);

        if (test_win($spielfeld, $column, $i)) {
            echo '{"board": '.json_encode($spielfeld).', "finished": true, "turn": '.$turn.'}';
        } else {
            echo '{"board": '.json_encode($spielfeld).', "finished": false, "turn": '.$turn.'}';
        }

    }
}

function test_win($spielfeld, $column, $row) {

    if (test_vertical($spielfeld, $column, $row)) {
        return true;
    } else if (test_horizontal($spielfeld, $column, $row)) {
        return true;
    } else if (test_diagonal_left($spielfeld, $column, $row)) {
        return true;
    } else if (test_diagonal_right($spielfeld, $column, $row)) {
        return true;
    } else {
        return false;
    }
}

function test_vertical($spielfeld, $column, $row) {

    $vertical = 1;
    global $value;

    if ($row <= 2) {
        $j = $row+1;

        while ($vertical > 0 && $vertical < 4) {
            if (((int)$spielfeld[$j][$column]) == $value) {
                $vertical++;
                $j++;
            } else {
                break;
            }
        }

        if ($vertical == 4) {
            win();
            return true;
        }
    }

    return false;
}

function test_horizontal($spielfeld, $column, $row) {
    $horizontal = 1; 
    $c = $column - 1;
    global $value;

    while ($c >= 0) {
        if (((int)$spielfeld[$row][$c]) == $value) {
            $horizontal++;
        } else {
            break;
        }
        $c--;
    }

    $c = $column + 1;

    while ($c < 7) {

        if (((int)$spielfeld[$row][$c]) == $value) {
            $horizontal++;
        } else {
            break;
        }
        $c++;
    }

    if ($horizontal >= 4) {
        win();
        return true;
    }

    return false;
}

function test_diagonal_left($spielfeld, $column, $row) {
        
    $diagonal_left = 1;
    global $value;
    $c = $column -1;
    $r = $row - 1;

    while ($c >= 0 && $r >= 0) {
        if (((int)$spielfeld[$r][$c]) == $value) {
            $diagonal_left++;
            $c--;
            $r--;
        }else break;
    }

    $c = $column + 1;
    $r = $row + 1;
    while ($c < 7 && $r < 6) {
        if (((int)$spielfeld[$r][$c]) == $value)  {
            $diagonal_left++;
            $c++;
            $r++;
        } else break;
    }

    if ($diagonal_left >= 4) {
        win();
        return true;
    }

    return false;
}


function test_diagonal_right($spielfeld, $column, $row) {
    
    $diagonal_right = 1;
    global $value;
    $c = $column + 1;
    $r = $row - 1;

    while ($c >= 0 && $r >= 0) {
        if (((int)$spielfeld[$r][$c]) == $value) {
            $diagonal_right++;
            $c++;
            $r--;
        }else break;
    }

    $c = $column - 1;
    $r = $row + 1;
    while ($c < 7 && $r < 6) {
        if (((int)$spielfeld[$r][$c]) == $value)  {
            $diagonal_right++;
            $c--;
            $r++;
        } else break;
    }

    if ($diagonal_right >= 4) {
        win();
        return true;
    }

    return false;

}


function win() {

    $query = sprintf("UPDATE game 
                      SET finished='true' 
                      WHERE id=%d",
                      $_SESSION['gameid']);
    mysql_query($query);

    global $whoami, $player1, $player2;

    $query = sprintf("UPDATE player
                      SET won = won + 1, played = played + 1
                      WHERE id=%d",
                      ($whoami == 1) ? $player1 : $player2);
    mysql_query($query);

    $query = sprintf("UPDATE player
                      SET played = played + 1
                      WHERE id=%d",
                      ($whoami == 1) ? $player2 : $player1);
    mysql_query($query);
}

?>

