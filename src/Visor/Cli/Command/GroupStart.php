<?php

namespace Visor\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use \Supervisord\Connection;
use \Supervisord\Client;

class GroupStart extends Command
{
    protected function configure()
    {
        $this->setName('group:start')
             ->setDescription('Start all processes in a group')
             ->addArgument('name', InputArgument::REQUIRED, 'Group name');
    }

    protected function execute( InputInterface $input, OutputInterface $output )
    {
        $connection = new Connection( 'http://localhost:9001/RPC2' );
        $client = new Client( $connection );
        
        $output->writeln( sprintf( '[starting all prcesses in group %s]', $input->getArgument( 'name' ) ) );
        
        $client->startProcessGroup( $input->getArgument( 'name' ) );
    }
}