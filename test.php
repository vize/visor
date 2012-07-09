<?php

namespace Visor;

require_once 'autoloader.php';

$config = new \Supervisord\Config;
$config->import( new \SplFileObject( 'default.conf' ) );

$server = new \Supervisord\Server( $config );

if( !$server->isRunning() )
{
    $server->restart();
}

$connection = new \Supervisord\Connection( 'http://localhost:9001/RPC2' );
$client = new \Supervisord\Client( $connection );

//var_dump( $connection->call( 'system.listMethods' ) );

//var_dump( $client->methodHelp( 'supervisor.getProcessInfo' ) );

//var_dump( $client->addProcessGroup( 'something' ) );
//
//var_dump( $client->startProcessGroup( 'something' ) );

//var_dump( $client->stopProcessGroup( 'something' ) );
//
//var_dump( $client->removeProcessGroup( 'something' ) );

$processes = $client->getAllProcessInfo();

//var_dump( $processes );

$table = new \Cli\Table( $processes );
$table->render( array( 'pid', 'name', 'description', 'statename', 'group' ) );

//var_dump( $client->getAllProcessInfo() );
//var_dump( $client->getProcessInfo( 'something_00' ) );
