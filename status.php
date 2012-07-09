<?php

namespace Visor;

require_once 'autoloader.php';

$config = new \Supervisord\Config;
$config->import( new \SplFileObject( 'default.conf' ) );

$server = new \Supervisord\Server( $config );
$connection = new \Supervisord\Connection( 'http://localhost:9001/RPC2' );
$client = new \Supervisord\Client( $connection );

$table = new \Cli\Table( $client->getAllProcessInfo() );
$table->render( array( 'statename', 'pid', 'group', 'name', 'description', 'logfile' ) );