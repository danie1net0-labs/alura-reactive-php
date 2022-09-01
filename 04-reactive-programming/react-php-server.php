<?php

require __DIR__ . '/vendor/autoload.php';

use React\Http\HttpServer;
use React\Http\Message\Response;

$counter = 0;

$http = new HttpServer(function () use (&$counter) {
    return Response::plaintext('Welcome number ' . ++$counter . "!\n");
});

$socket = new React\Socket\SocketServer($argv[1] ?? '0.0.0.0:8080');

$http->listen($socket);

echo 'Listening on ' . str_replace('tcp:', 'http:', $socket->getAddress()) . PHP_EOL;