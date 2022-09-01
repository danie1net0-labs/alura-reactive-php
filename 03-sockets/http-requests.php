<?php

$streams = [
    stream_socket_client('tcp://localhost:8000'),
    stream_socket_client('tcp://localhost:8001'),
    stream_socket_client('tcp://localhost:8002'),
    fopen('../02-reading-files/files/file1.txt', 'rb'),
    fopen('../02-reading-files/files/file2.txt', 'rb'),
];

fwrite($streams[0], 'GET / HTTP/1.1' . PHP_EOL . PHP_EOL);
fwrite($streams[1], 'GET / HTTP/1.1' . PHP_EOL . PHP_EOL);

foreach ($streams as $stream) {
    stream_set_blocking($stream, false);
}

do {
    $readStreams = $streams;

    $readyStreamsCount = stream_select($readStreams, $write, $except, 0, 200000);

    if ($readyStreamsCount === 0) {
        continue;
    }

    foreach ($readStreams as $key => $readStream) {
        $content = stream_get_contents($readStream);
        $endOfHttpPosition = strpos($content, "\r\n\r\n");

        if ($endOfHttpPosition) {
            echo substr($content, $endOfHttpPosition + 4);
        } else {
            echo $content;
        }

        unset($streams[$key]);
    }
} while (!empty($streams));

echo 'All streams read' . PHP_EOL;