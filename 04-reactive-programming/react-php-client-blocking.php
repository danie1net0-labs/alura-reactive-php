<?php

use Psr\Http\Message\ResponseInterface;
use React\Http\Browser;
use function React\Async\await;
use function React\Promise\all;

require __DIR__ . '/vendor/autoload.php';

$client = new Browser();

$promise1 = $client->get('http://localhost:8000');
$promise2 = $client->get('http://localhost:8001');

try {
    /** @var ResponseInterface $response1 */
    $response1 = await($promise1);

    /** @var ResponseInterface $response2 */
    $response2 = await($promise2);

    echo $response1->getBody();
    echo $response2->getBody();
} catch (Throwable $exception) {
    echo 'Error: ' . $exception->getMessage() . PHP_EOL;
}

//$promises = [
//    $client->get('http://localhost:8000'),
//    $client->get('http://localhost:8001'),
//];
//
//try {
//    $responses = await(all($promises));
//
//    array_map(static fn (ResponseInterface $response) => print($response->getBody()), $responses);
//} catch (Throwable $exception) {
//    echo 'Error: ' . $exception->getMessage() . PHP_EOL;
//}
