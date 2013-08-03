//builds a svg element out of a string, fix for jQuery
function SVG(tag){
    return document.createElementNS('http://www.w3.org/2000/svg', tag);
}



$(function() {

    var board = $("svg g#board");
    var tokens = $("svg g#tokens");
    var tokenMask = $("svg #token-holes");
    var cellWidth = 80;
    var tokenRadius = 37;


    function buildTokens() {

        tokens.empty();
        console.log(gameState);

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

    board.click(function(e) {
            
            var offX  = (e.offsetX || e.clientX - $(e.target).offset().left);
            var col = Math.floor(offX / cellWidth);

            $.get('turn.php', {column: col}, function(data){
                updateStuff(data); 

            });
            
    });

    buildTokens();
  

    function polling() {
        
        $.ajax({
            url: 'poll.php', 
            success: function(data, textStatus, jqXHR){
                updateStuff(data);     
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("polling failed",textStatus,errorThrown);    
            }});
     }

     
     function updateStuff(data) {


         if (data.error == undefined) {
             if (data.finished == 'false' || data.finished == undefined || !data.finished) {
                if (data.board != undefined) {
                    gameState = data.board;    
                    buildTokens();
                }

             } else {
                console.log('game over');
             }

         } else {
            //happens every time you clock out of turn or the game is over
         }


     }
    
     setInterval(polling, 1000);

            

});
