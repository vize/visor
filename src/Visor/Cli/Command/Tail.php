<?php

namespace Visor\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use \Supervisord\Connection\CurlConnection;
use \Supervisord\Client;

class Tail extends Command
{
    protected function configure()
    {
        $this->setName('process:tail')
             ->setDescription('Tail process output')
             ->addArgument('name', InputArgument::REQUIRED, 'Process name (group:name)');
    }

    protected function execute( InputInterface $input, OutputInterface $output )
    {        
        $connection = new CurlConnection( '127.0.0.1:9900/RPC2' );
        
        $client = new Client( $connection );
        
        $tail = $client->tailProcessStdoutLog( $input->getArgument( 'name' ) );

        $output->writeln( is_array( $tail ) && !empty( $tail ) ? reset( $tail ) : '[no output]' );
    }
}