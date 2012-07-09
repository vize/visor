<?php

namespace Visor;

require_once 'vendor/autoload.php';

$config = new \Supervisord\Config;
$config->import( new \SplFileObject( 'default.conf' ) );

$server = new \Supervisord\Server( $config );
$server->restart();