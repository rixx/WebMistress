<?php

    session_start();
    
    $link = mysql_connect('127.0.0.1', 'rix', 'blakeks');

    if (!$link) {
        echo htmlspecialchars('nope');
        die('Verbindung schlug fehl: ' . mysql_error());
    }

    $db = mysql_select_db("viergewinnt",$link);

    $_SESSION['gameid'] = $_GET['id'];

    include('exitRemaining.php');

    $query = sprintf("select player2 from game where id='%s'",$_SESSION['gameid']);
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);

    if ($row['player2'] != 'null') {

        echo "Sorry, das Spiel ist schon voll";

    } else {

        $query = sprintf("select id from player where name='%s'",$_SESSION['nick']);
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);

        $query = sprintf("update game set player2='%s'", $row['id']);
        mysql_query($query);

        header('Location: game.php');
    }

   ?>


