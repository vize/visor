<?php

namespace Visor;

class FunctionalTest extends \PHPUnit_Framework_TestCase
{    
    public function testExample()
    {
        $visor = new \Visor\Visor( '127.0.0.1:9900/RPC2' );
        
        $group = $visor->create( 'syslog', 'tail -f /var/log/syslog' )->run( 1 );
        
        $group->run( 5 );
    }
}