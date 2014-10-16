<html>
    <head>
        <title>Chat HTTP</title>
        <script src="js/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
        <link rel="stylesheet" href="css/chat.css" type="text/css" media="screen" charset="utf-8">
        <link rel="stylesheet" href="semantic/css/semantic.min.css" type="text/css">
    </head>
    <body>
        <div id="content">
            <div class="ui segment">
                <div id="messages"></div>
            </div>
            <div class="ui segment form">
                <div class="field">
                    <textarea class="ui input" name="message" id="message" placeholder="Escreva a mensagem e aperte [enter] para enviar"></textarea><br>
                </div>
                
                <div class="inline field">
                    <label>Apelido</label> 
                    <input type="text" name="nick" id="nick">
                </div>
            </div>
        </div>
        <script src="js/chat.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>