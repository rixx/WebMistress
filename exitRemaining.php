<?php
$query = sprintf("update game left join player p1 on game.player1 = p1.id 
                    left join player p2 on game.player2 = p2.id
                  set finished='true'
                  where p2.name='%s' or p1.name='%s'",
              $_SESSION['nick'], $_SESSION['nick']);
mysql_query($query);

?>

