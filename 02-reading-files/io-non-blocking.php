<?php

$streams = [
    fopen('files/file1.txt', 'rb'),
    fopen('files/file2.txt', 'rb'),
];

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
        echo fgets($readStream);

        unset($streams[$key]);
    }
} while(! empty($streams));

echo 'All files read' . PHP_EOL;