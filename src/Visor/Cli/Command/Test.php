<?php

namespace Visor\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use \Supervisord\Connection\CurlConnection;
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
        $visor = new Visor( '127.0.0.1:9900/RPC2' );
        
        $group = $visor->create( 'syslog', 'tail -f /var/log/syslog' )->run( 1 );
        
        $group->run( 5 );
        
        var_dump( $visor->getClient()->getAllProcessInfo() );
        
//        $visor->find( 'syslog' )->run( 10 );
//        $visor->find( 'syslog' )->run( 0 );
        
//        $output->write( $visor->help( $connection, 'supervisor.getAllProcessInfo' ) );
    }
}