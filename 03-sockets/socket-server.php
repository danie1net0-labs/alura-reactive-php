<?php

$socket = stream_socket_server('tcp://0.0.0.0:8002');

$connection = stream_socket_accept($socket);

sleep($sleep = random_int(1, 5));

fwrite($connection, "Socket connected after $sleep seconds" . PHP_EOL);

fclose($connection);


