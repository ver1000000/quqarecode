<?php

namespace App;

use ClickHouseDB\Client;
use Swoole\WebSocket\Server;

class WebSocketServer
{
    protected $server;
    protected $db;

    public function __construct() {
        $this->server = new Server("0.0.0.0", 8000);
        $this->server->on('open', [$this, 'onOpen']);
        $this->server->on('message', [$this, 'onMessage']);
        $this->server->on('close', [$this, 'onClose']);

        $config = [
            'host' => getenv('CLICKHOUSE_HOST'),
            'port' => getenv('CLICKHOUSE_PORT'),
            'username' => getenv('CLICKHOUSE_USER'),
            'password' => getenv('CLICKHOUSE_PASSWORD'),
        ];
        $this->db = new Client($config);
        $this->db->database(getenv('CLICKHOUSE_DB'));

        $this->server->start();
    }

    public function onOpen(Server $server, $request) {
        echo "New connection! ({$request->fd})\n";
    }

    public function onMessage(Server $server, $frame) {
        try {
            $data = json_decode($frame->data, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON data');
            }

            $this->db->insert('events', [
                [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'props' => json_encode($data['props']),
                    'timestamp' => null // Use default timestamp
                ]
            ]);

            foreach ($server->connections as $fd) {
                if ($frame->fd !== $fd) {
                    $server->push($fd, $frame->data);
                }
            }
        } catch (\Exception $e) {
            echo "Error handling message: " . $e->getMessage() . "\n";
            // Optionally, send an error message back to the client
            $server->push($frame->fd, json_encode(['error' => $e->getMessage()]));
        }
    }

    public function onClose(Server $server, $fd) {
        echo "Connection {$fd} has disconnected\n";
    }
} 