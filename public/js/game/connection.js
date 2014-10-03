var conn = new WebSocket('ws://192.168.0.24:8080');

conn.onopen = function(e) {
    var data = Block.random();
    
    conn.send(JSON.stringify(data));
    
    Block.create(data.content, true);
};

conn.onmessage = function(e) {
    var data = $.parseJSON(e.data);
    
    Block[data.type](data.content);
};