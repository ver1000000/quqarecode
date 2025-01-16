<?php

namespace App\Command;

use App\WebSocketServer;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'app:start-websocket-server',
    description: 'Starts the WebSocket server'
)]
class StartWebSocketServerCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Starting WebSocket server...');

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new WebSocketServer()
                )
            ),
            8080,
            '0.0.0.0'
        );

        $output->writeln('WebSocket server listening on 0.0.0.0:8080');
        
        $server->run();

        return Command::SUCCESS;
    }
} 