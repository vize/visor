<?php

namespace Visor\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use \Visor\Cli\Table;

use \Supervisord\Config;
use \Supervisord\Server;

use \SplFileObject;

class Status extends Command
{
    protected function configure()
    {
        $this->setName('server:status')
             ->setDescription('Display server status');
    }

    protected function execute( InputInterface $input, OutputInterface $output )
    {
        $config = new Config;
        $config->import( new SplFileObject( 'default.conf' ) );

        $server = new Server( $config );
        
        if( $server->isRunning() )
        {
            $output->writeln( sprintf( '[server running as pid %s]', $server->getPid() ) );
        }
        
        else $output->writeln( '[server not running]' );
    }
}