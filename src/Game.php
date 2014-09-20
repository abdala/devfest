<?php
namespace Devfest;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Game implements MessageComponentInterface 
{
    protected $clients;

    public function __construct() 
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) 
    {
        $msgs = [];
            
        foreach ($this->clients as $client) {
            $msgs[] = $this->clients[$client];
        }
        
        $this->clients->attach($conn);
        
        $conn->send(json_encode(['type' => 'init', 'content' => $msgs]));

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) 
    {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        
        $this->clients[$from] = json_decode($msg);

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) 
    {
        foreach ($this->clients as $client) {
            if ($conn !== $client) {
                $client->send(json_encode(['type' => 'delete', 'content' => $this->clients[$conn]]));
            }
        }
        
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        
        $conn->close();
    }
}