<?php

namespace Visor\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use \Supervisord\Connection\CurlConnection;
use \Supervisord\Client;

class GroupStop extends Command
{
    protected function configure()
    {
        $this->setName('group:stop')
             ->setDescription('Stop all processes in a group')
             ->addArgument('name', InputArgument::REQUIRED, 'Group name');
    }

    protected function execute( InputInterface $input, OutputInterface $output )
    {
        $connection = new CurlConnection( '127.0.0.1:9900/RPC2' );
        
        $client = new Client( $connection );
        
        $output->writeln( sprintf( '[stopping all prcesses in group %s]', $input->getArgument( 'name' ) ) );
        
        $client->stopProcessGroup( $input->getArgument( 'name' ) );
    }
}