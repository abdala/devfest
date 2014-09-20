<html>
    <head>
        <title>Pega-pega</title>
        <script src="js/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
        <link rel="stylesheet" href="css/game.css" type="text/css" media="screen" charset="utf-8">
    </head>
    <body>
        <h1>Pega-pega virtual</h1>
        <div id="space">
            
        </div>
        <script type="text/javascript">
            var conn = new WebSocket('ws://localhost:8080'),
                Block = {id: new Date().getTime()}
                
            Block.create = function(data, color) {
                var $div = $('<div class="block" id="' + data.id + '">');
                
                $div.css({top: data.y, left: data.x});
                
                if (color) {
                    $div.css('background', 'red');
                }
                
                $('#space').append($div);
            }
            
            Block.init = function(data) {
                if (data.length) {
                    $.each(data, function(){
                        Block.create(this.content);
                    });
                }
            }
            
            Block.delete = function(data) {
                $('#'+data.content.id).remove();
            }
            
            Block.update = function(data) {
                var $block = $('#'+data.id), 
                    x = data.x, 
                    y = data.y;
                
                if (! $block.length) {
                    Block.create(data);
                }
                
                x = x < 0 ? 0 : x; 
                x = x > 750 ? 750 : x;
                y = y < 0 ? 0 : y;
                y = y > 350 ? 350 : y;
                
                $block.css({top: y, left: x});
                data.x = x;
                data.y = y;
                
                Block.collision(data);
            }
            
            Block.collision = function(data) {
                $('.block').not('#'+data.id).each(function(){
                    var $this = $(this),
                    cx = parseInt($this.css('left'), 10),
                    cy = parseInt($this.css('top'), 10);
                    
                    if (cy == data.y && cx == data.x) {
                        alert('Pegou!!!!!');
                    }
                });
            }
            
            conn.onopen = function(e) {
                 var data = {
                    type: 'update',
                    content: {
                        id: Block.id,
                        x: Math.floor((Math.random()*15))*50,
                        y: Math.floor((Math.random()*7))*50
                    }
                }
                
                conn.send(JSON.stringify(data));
                
                Block.create(data.content, true);
            };

            conn.onmessage = function(e) {
                var data = $.parseJSON(e.data);
                
                Block[data.type](data.content);
            };
            
            $(document).keypress(function(e){
                //top: 119 left:100 right:97 bottom:115
                var $block = $('#' + Block.id),
                    x = parseInt($block.css('left'), 10),
                    y = parseInt($block.css('top'), 10),
                    increment = 50, valuex = x, valuey = y;
                
                switch (e.which) {
                    case 119:
                        valuey = y - increment;
                        $block.css('top', valuey < 0 ? 0 : valuey);
                        break;
                    case 115:
                        valuey = y + increment;
                        $block.css('top', valuey > 350 ? 350 : valuey);
                        break;
                    case 97:
                        valuex = x - increment;
                        $block.css('left', valuex < 0 ? 0 : valuex);
                        break;
                    case 100:
                        valuex = x + increment;
                        $block.css('left', valuex > 750 ? 750 : valuex);
                        break;
                }
                
                var data = {
                    type: 'update',
                    content: {
                        id: Block.id,
                        x: valuex,
                        y: valuey
                    }
                }
                
                conn.send(JSON.stringify(data));
                Block.collision(data.content);
            });
        </script>
    </body>
</html>