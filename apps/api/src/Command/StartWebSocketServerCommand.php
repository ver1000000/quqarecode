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
        try {
            $output->writeln('Starting Swoole WebSocket server...');

            // Instantiate the WebSocketServer which uses Swoole
            $webSocketServer = new WebSocketServer();
            $webSocketServer->start();

            $output->writeln('Swoole WebSocket server is running.');
        } catch (\Exception $e) {
            $output->writeln('Error starting WebSocket server: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
} 