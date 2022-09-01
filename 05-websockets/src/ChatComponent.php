<?php

namespace App;

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use SplObjectStorage;

class ChatComponent implements MessageComponentInterface
{
    private SplObjectStorage $chats;

    public function __construct()
    {
        $this->chats = new SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn): void
    {
        print_r(get_debug_type($conn));
        echo "New connection accepted." . PHP_EOL;

        $this->chats->attach($conn);
    }

    public function onClose(ConnectionInterface $conn): void
    {
        echo 'Connection closed.' . PHP_EOL;

        $this->chats->detach($conn);
    }

    public function onError(ConnectionInterface $conn, Exception $e): void
    {
        echo 'Error: ' . $e->getTraceAsString();
    }

    public function onMessage(ConnectionInterface $conn, MessageInterface $msg): void
    {
        /** @var ConnectionInterface $chat */
        foreach ($this->chats as $chat) {
            if ($chat !== $conn) {
                 $chat->send((string) $msg);
            }
        }
    }
}