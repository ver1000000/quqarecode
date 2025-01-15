<?php

namespace App\Command;

use App\WebSocketServer;
use Ratchet\Server\IoServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartWebSocketServerCommand extends Command
{
    protected static $defaultName = 'app:start-websocket-server';

    protected function configure()
    {
        $this->setDescription('Starts the WebSocket server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Starting WebSocket server...');

        $server = IoServer::factory(
            new WebSocketServer(),
            8080
        );

        $server->run();

        return Command::SUCCESS;
    }
} 