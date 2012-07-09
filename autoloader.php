<?php

use \Symfony\Component\ClassLoader\UniversalClassLoader;
require_once __DIR__.'/UniversalClassLoader.php';

$classLoader = new UniversalClassLoader;
$classLoader->registerNamespace( 'Visor', __DIR__ );
$classLoader->registerNamespace( 'Supervisord', __DIR__ );
$classLoader->registerNamespace( 'Cli', __DIR__ );
$classLoader->register();