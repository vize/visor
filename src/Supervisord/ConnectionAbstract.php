<?php

namespace Supervisord;

abstract class ConnectionAbstract implements Connection
{
    protected $dsn;
    
    public function __construct( $dsn )
    {
        $this->dsn = $dsn;
        
        // Confirm server is active
        $this->call( 'supervisor.getSupervisorVersion' );
    }
    
    protected function validateResponse( $response )
    {
        switch( gettype( $response ) )
        {
            case 'NULL' : throw new ConnectionException( sprintf( 'Could not connect to server at %s', $this->dsn ) );
            case 'array' :
                if( isset( $response[ 'faultString' ], $response[ 'faultCode' ] ) )
                {
                    throw new ConnectionException( $response[ 'faultString' ], $response[ 'faultCode' ] );
                }
        }
    }
}