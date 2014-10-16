var conn = new WebSocket('ws://localhost:8080');

conn.onopen = function(e) {
    var data = {
        nick: $('#nick').val(),
        text: "Entrou na sala"
    }
    
    conn.send(data);
};

conn.onmessage = function(e) {
    var data = $.parseJSON(e.data),
        $messages = $('#messages');
    
    $messages.append("<p>" + data.nick + ": " + data.text + "</p>")
    $('#messages').scrollTop(9999999999);
};

$('#message').keypress(function(e){
    if (e.keyCode != 13) {
        return true;
    }
    
    var data = {
        nick: $('#nick').val(),
        text: this.value
    }
    
    conn.send(JSON.stringify(data));
    
    $("#messages").append("<p><strong>você</strong>: " + this.value + "</p>");
    $('#messages').scrollTop(9999999999);
    this.value = '';
    
    return false;
});

$('#nick').val('convidado' + new Date().getTime());