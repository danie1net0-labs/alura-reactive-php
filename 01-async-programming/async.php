<?php

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

require_once 'vendor/autoload.php';

$client = new Client();

$promise1 = $client->getAsync('http://localhost:8000');
$promise2 = $client->getAsync('http://localhost:8001');

/** @var ResponseInterface $responses */
$responses = GuzzleHttp\Promise\Utils::unwrap([
    $promise1,
    $promise2,
]);

echo 'Resposta 1: ' . $responses[0]->getBody()->getContents();
echo 'Resposta 2: ' . $responses[1]->getBody()->getContents();