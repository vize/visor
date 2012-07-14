<?php

namespace Visor\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use \Supervisord\InetConnection;
use \Supervisord\Client;

class Version extends Command
{
    protected function configure()
    {
        $this->setName('server:version')
             ->setDescription('Display server version');
    }

    protected function execute( InputInterface $input, OutputInterface $output )
    {
        $connection = new InetConnection( 'http://localhost:9001/RPC2' );
        $client = new Client( $connection );
        
        $output->writeln( sprintf( 'Supervisord version: %s', $client->getSupervisorVersion() )  );
        $output->writeln( sprintf( 'Twiddler version: %s', $connection->call( 'twiddler.getAPIVersion' ) ) );
    }
}