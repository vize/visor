<?php

namespace Visor;

require_once 'vendor/autoload.php';

$config = new \Supervisord\Config;
$config->import( new \SplFileObject( 'default.conf' ) );

$server = new \Supervisord\Server( $config );
$connection = new \Supervisord\Connection( 'http://localhost:9001/RPC2' );
$client = new \Supervisord\Client( $connection );

$tail = $client->tailProcessStdoutLog( $argv[ 1 ] );

echo( is_array( $tail ) && !empty( $tail ) ? $tail[ 0 ] : '[no output]' );