<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\OriginCheck;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Devfest\App;

require dirname(__DIR__) . '/vendor/autoload.php';

$checkedApp = new OriginCheck(new WsServer(new App), ['localhost']);
$checkedApp->allowedOrigins[] = 'localhost'; //dominio do seu site

$server = IoServer::factory(
    new HttpServer(
        $checkedApp
    ),
    8080
);

$server->run();