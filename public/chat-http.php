<html>
    <head>
        <title>Chat HTTP</title>
        <script src="js/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
        <link rel="stylesheet" href="css/main.css" type="text/css" media="screen" charset="utf-8">
    </head>
    <body>
        <div id="messages">
            
        </div>
        <div>
            <textarea name="message" id="message" placeholder="Escreva a mensagem"></textarea><br>
            Apelido: <input type="text" name="nick" id="nick">
        </div>
        <script type="text/javascript">
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
                if (e.keyCode == 13) {
                    var data = {
                        nick: $('#nick').val(),
                        text: this.value
                    }
                    
                    conn.send(JSON.stringify(data));
                    
                    $("#messages").append("<p><strong>você</strong>: " + this.value + "</p>");
                    $('#messages').scrollTop(9999999999);
                    this.value = '';
                    
                    return false;
                }
            });
            
            $('#nick').val('convidado' + new Date().getTime() );
        </script>
    </body>
</html>