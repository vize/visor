<?php

namespace Visor\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

use \Supervisord\Connection;
use \Supervisord\Client;

use \Visor\Cli\Table;

class Ls extends Command
{
    protected function configure()
    {
        $this->setName('process:ls')
             ->setDescription('Display process list');
    }

    protected function execute( InputInterface $input, OutputInterface $output )
    {
        $connection = new Connection( 'http://localhost:9001/RPC2' );
        $client = new Client( $connection );

        $table = new Table( $client->getAllProcessInfo() ?: array() );
        
        $headers = $input->getOption( 'verbose' ) ? null : array( 'statename', 'pid', 'group', 'name', 'description', 'logfile' );
        
        $output->writeln( $table->render( $headers ) );
    }
}