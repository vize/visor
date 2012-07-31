<?php

namespace Visor;

use \Supervisord\Connection\CurlConnection;
use \Supervisord\Client;

class Visor
{
    private $client;
    
    /**
     * Create a new Visor client
     * 
     * @param string $dsn Eg. '127.0.0.1:9900'
     */
    public function __construct( $dsn )
    {
        $connection = new CurlConnection( $dsn );
        
        $this->client = new Client( $connection );
    }
    
    public function create( $name, $command )
    {
        return new Process\Group( $this->client, $name, $command );
    }
    
    /** @return \Supervisord\Client */
    public function getClient()
    {
        return $this->client;
    }
}