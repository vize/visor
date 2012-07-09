<?php

namespace Supervisord;

class Connection
{
    private $url;
    
    public function __construct( $url )
    {
        $this->url = $url;
    }
    
    public function call( $method, $params = array() )
    {
        $curl = curl_init();

        curl_setopt( $curl, \CURLOPT_URL, $this->url );
        curl_setopt( $curl, \CURLOPT_POST, 1 );
        curl_setopt( $curl, \CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, \CURLOPT_POSTFIELDS, xmlrpc_encode_request( $method, $params ) );
        
        $response = xmlrpc_decode( curl_exec( $curl ) );        
        curl_close( $curl );
        
        if( isset( $response[ 'faultString' ], $response[ 'faultCode' ] ) )
        {
            throw new ConnectionException( $response[ 'faultString' ], $response[ 'faultCode' ] );
        }

        return $response;
    }
}