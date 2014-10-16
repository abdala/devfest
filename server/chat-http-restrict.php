<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\OriginCheck;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Devfest\Chat;

require dirname(__DIR__) . '/vendor/autoload.php';

$checkedApp = new OriginCheck(new WsServer(new Chat), ['localhost']);
$checkedApp->allowedOrigins[] = 'localhost'; //dominio do seu site

$server = IoServer::factory(
    new HttpServer(
        $checkedApp
    ),
    8080
);

$server->run();