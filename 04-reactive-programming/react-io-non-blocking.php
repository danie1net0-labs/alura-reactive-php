<?php

use React\EventLoop\Loop;
use React\Stream\DuplexResourceStream;
use React\Stream\ReadableResourceStream;

require_once 'vendor/autoload.php';

$loop = Loop::get();

$streams = [
    new ReadableResourceStream(stream_socket_client('tcp://localhost:8002'), $loop),
    new ReadableResourceStream(fopen('../02-reading-files/files/file1.txt', 'rb'), $loop),
    new ReadableResourceStream(fopen('../02-reading-files/files/file2.txt', 'rb'), $loop),
];

$http = (new DuplexResourceStream(stream_socket_client('tcp://localhost:8000'), $loop));

$http->write('GET / HTTP/1.1' . "\r\n\r\n");

$http->on('data', function (string $data) {
    $endOfHttpPosition = strpos($data, "\r\n\r\n");

    echo substr($data, $endOfHttpPosition + 4);
});

foreach ($streams as $readableStream) {
    $readableStream->on('data', fn (string $data) => print($data));
}

$loop->run();