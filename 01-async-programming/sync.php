<?php

use GuzzleHttp\Client;

require_once 'vendor/autoload.php';

$client = new Client();

$response1 = $client->get('http://localhost:8000');
$response2 = $client->get('http://localhost:8001');

echo 'Resposta 1: ' . $response1->getBody()->getContents();
echo 'Resposta 2: ' . $response2->getBody()->getContents();