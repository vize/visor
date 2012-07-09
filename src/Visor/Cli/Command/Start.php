<?php

namespace Visor\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use \Supervisord\Config;
use \Supervisord\Server;

use \SplFileObject;

class Start extends Command
{
    protected function configure()
    {
        $this->setName('server:start')
             ->setDescription('Start supervisord');
    }

    protected function execute( InputInterface $input, OutputInterface $output )
    {        
        $config = new Config;
        $config->import( new SplFileObject( 'default.conf' ) );

        $server = new Server( $config );
        $server->restart();
        
        $output->writeln( '[starting supervisord]' );
    }
}