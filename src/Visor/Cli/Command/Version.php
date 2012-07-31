<?php

namespace Visor\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use \Supervisord\Connection\CurlConnection;
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
        $connection = new CurlConnection( '127.0.0.1:9900/RPC2' );
        
        $client = new Client( $connection );
        
        $output->writeln( sprintf( 'Supervisord version: %s', $client->getSupervisorVersion() )  );
        $output->writeln( sprintf( 'Twiddler version: %s', $connection->call( 'twiddler.getAPIVersion' ) ) );
    }
}