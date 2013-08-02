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
                
            if (data.error == undefined) {
                gameState = data.board;    
                buildTokens();
            }

            });
            
    });

    buildTokens();
  

    function polling() {
        
        $.ajax({
            url: 'poll.php', 
            success: function(data, textStatus, jqXHR){
            
                //console.log("poll",data, textStatus, jqXHR);
                gameState = data.board;
                buildTokens();
                //todo: finished
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("polling failed",textStatus,errorThrown);    
            }});
     }

     setInterval(polling, 1000);

            

});
