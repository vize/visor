<?php

namespace Visor\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

use \Supervisord\Config;
use \Supervisord\Server;

use \Visor\Cli\Shell;

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
        $config->import( new SplFileObject( 'vendor/vize/supervisord/supervisord.conf' ) );

        $server = new Server\Local( $config );
        $server->restart();
        
        $output->writeln( '<info>[starting supervisord]</info>' );
    }
}