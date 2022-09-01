<?php

use Psr\Http\Message\ResponseInterface;
use React\Http\Browser;

require __DIR__ . '/vendor/autoload.php';

$client = new Browser();

$client->get('http://localhost:8000')
    ->then(
        fn (ResponseInterface $response) => print($response->getBody()),
        fn (Exception $exception) => print($exception->getMessage())
    );

$client->get('http://localhost:8001')
    ->then(
        fn (ResponseInterface $response) => print($response->getBody()),
        fn (Exception $exception) => print($exception->getMessage())
    );