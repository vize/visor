<?php

namespace Visor\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use \Supervisord\InetConnection;
use \Supervisord\Client;

use \Visor\Cli\Table;

use \Visor\Visor,
    \Visor\Group,
    \Visor\Process;

class Test extends Command
{
    protected function configure()
    {
        $this->setName('test')
             ->setDescription('Test');
    }

    protected function execute( InputInterface $input, OutputInterface $output )
    {
        $connection = new InetConnection( 'http://localhost:9001/RPC2' );
        $visor = new Visor;
        
        $group = new Group( 'application1' );
        $group->save( $connection );
        
        $process = new Process( $group, 'proc_1', 'tail -f /var/log/syslog' );
        $process->save( $connection, true );
        
        $process2 = $visor->findOne( $connection, 'application1', 'proc_1' );
        $process2->stop( $connection );
        
//        $output->write( $visor->help( $connection, 'supervisor.getAllProcessInfo' ) );
    }
}