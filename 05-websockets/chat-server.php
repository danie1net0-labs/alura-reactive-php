<?php

use App\ChatComponent;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require_once 'vendor/autoload.php';

$chatComponent = new ChatComponent();
$socketServer = new WsServer($chatComponent);
$httpServer = new HttpServer($socketServer);

$server = IoServer::factory($httpServer, $argv[1] ?? 8003);

$server->run();