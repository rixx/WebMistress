//builds a svg element out of a string, fix for jQuery
function SVG(tag){
    return document.createElementNS('http://www.w3.org/2000/svg', tag);
}


//is called once the document is loaded
$(function() {

    var board = $("svg g#board");
    var tokens = $("svg g#tokens");
    var tokenMask = $("svg #token-holes");

    var cellWidth = 80;
    var tokenRadius = 37;
    var pollingIntervalID;
    var enemyIntervalID;

    
    /* iterates over the gameState array, draws colored circles */
    function buildTokens() {

        //removes all existing tokens
        tokens.empty();

        for (var row = 0; row < 6; row++) {
            for (var col = 0; col < 7; col++) {
    
                if (gameState[row][col] != null) {

                    $(SVG('circle'))
                        .attr('cx', cellWidth / 2 + col * cellWidth)
                        .attr('cy', cellWidth / 2 + row * cellWidth)
                        .attr('r', tokenRadius)
                        .attr('fill', players['player'+gameState[row][col]].color)
                        .appendTo(tokens);
                }
            }
        }
    }


    /* evaluates returns from a sent turn and regular polling */
    function updateStuff(data) {

         // error is only set if the player tries to move if it's not his turn or the game is over
         if (data.error == undefined) {
            
            player = $('#playerStatus');
            enemy = $('#enemyStatus');

            //todo: check if something has changed before redrawing
            if (data.board != undefined)  {
                 gameState = data.board;    
                 buildTokens();
            }

            // is only invoked if the game is still running
            if (data.finished == 'false' || data.finished == undefined || !data.finished) {
               
                // mark the right player as active
                if (data.turn != activePlayer) {
                    
                    $('.playerStatus.active').removeClass('active');
                    activePlayer = data.turn;

                    if (data.turn == playernum) {
                        player.addClass('active');
                    } else {
                        enemy.addClass('active');
                    }
                }    

             // if the game is over, mark winner and loser
             //todo: only do this the first time
             } else  {

                $('#gameStatus').text('GAME OVER');
                $('.playerStatus.active').removeClass('active');

                if (data.turn == playernum) {
                    player.addClass('loser');
                    enemy.addClass('winner');
                } else {
                    player.addClass('winner');
                    enemy.addClass('loser');
                }
                $('#links').html("<a href='/index.php'>Menu</a>");
                
            }
        } 
    }
  

    function polling() {
        
        $.ajax({
            url: '/api/pollGame.php', 
            success: function(data, textStatus, jqXHR){
                updateStuff(data);     
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("polling failed",textStatus,errorThrown);    
            },
            cache: false
        });
    }


    /* polls from the server so that the first player finds out when the
     * second joins and who he is */
    function getEnemy() {

        $.ajax({
            url: '/api/pollEnemy.php', 
            success: function(data) {
            
                // when the new player is returned, stop polling and set his name
                if (!data.error) {
                    players['player'+enemynum].name = data.enemy;
                    $('#enemyStatus').text(data.enemy);
                    clearInterval(enemyIntervalID);
                    console.log("clearing interval");
                }
            },
            cache: false});
    }
 

    // initializing the board (white holes in the blue rectangle)
    for (var row = 0; row < 6; row++) {
        for (var col = 0; col < 7; col++) {
    
            $(SVG('circle'))
                .attr('cx', cellWidth / 2 + col * cellWidth)
                .attr('cy', cellWidth / 2 + row * cellWidth)
                .attr('r', tokenRadius)
                .attr('fill', 'black')
                .appendTo(tokenMask);
        }
    }

    
    /* if the board is clicked, a post request is sent */
    board.click(function(e) {
            
            var offX  = (e.offsetX || e.clientX - $(e.target).offset().left);
            var col = Math.floor(offX / cellWidth);

            $.get('/api/turn.php', {column: col}, function(data){
                updateStuff(data); 
            });
    });

    /* initialize board, in case the first player has already made his move */
    buildTokens();

    /* no need to poll for the second player unless one is the first player ^^ */
    if (enemynum == 2) {
        enemyIntervalID = setInterval(getEnemy, 1000);
    }
    pollingIntervalID = setInterval(polling, 1000);
            
});
