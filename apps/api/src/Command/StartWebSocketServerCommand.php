<?php

namespace App\Command;

use App\WebSocketServer;
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
        $output->writeln('Starting Swoole WebSocket server...');

        // Instantiate the WebSocketServer which uses Swoole
        $webSocketServer = new WebSocketServer();

        // The server is started in the constructor of WebSocketServer
        // No need to call run() or start() here

        $output->writeln('Swoole WebSocket server is running.');

        return Command::SUCCESS;
    }
} 