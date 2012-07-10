<?php

namespace Visor\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use \Visor\Cli\Table;

use \Supervisord\Config;
use \Supervisord\Server;

use \Visor\Cli\Shell;

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
        $config->import( new SplFileObject( 'supervisord.conf' ) );

        $server = new Server( $config, new Shell );
        
        if( $server->isRunning() )
        {
            $output->writeln( sprintf( '<info>[server running as pid %s]</info>', $server->getPid() ) );
        }
        
        else $output->writeln( '<error>[server not running]</error>' );
    }
}