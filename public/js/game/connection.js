var conn = new WebSocket('ws://localhost:8080');

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