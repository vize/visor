<?php

namespace Supervisord;

class Server
{
    private $config;
    
    public function __construct( Config $config )
    {
        $this->config = $config;
    }
    
    public function start()
    {
        $this->exec( 'supervisord' );
    }
    
    public function stop()
    {
        $this->exec( sprintf( 'kill -QUIT %s', $this->getPid() ) );
    }
    
    public function clearLogs()
    {
        $this->exec( sprintf( 'kill -USR2 %s', $this->getPid() ) );
    }
    
    public function reload()
    {
        $this->exec( sprintf( 'kill -HUP %s', $this->getPid() ) );
    }
    
    public function restart()
    {
        if( !$this->isRunning() )
        {
            $this->start();
        }
        
        else $this->reload();
    }
    
    public function isRunning()
    {
        if( isset( $this->config[ 'supervisord' ][ 'pidfile' ] ) )
        {
            if( is_readable( $this->config[ 'supervisord' ][ 'pidfile' ] ) )
            {
                $pid = trim( file_get_contents( $this->config[ 'supervisord' ][ 'pidfile' ] ) );
                
                if( is_numeric( $pid ) && is_dir( sprintf( '/proc/%u', $pid ) ) ) 
                {
                    return (int) $pid;
                }
            }
        }
        
        return false;
    }
    
    public function getPid()
    {
        if( false === ( $pid = $this->isRunning() ) )
        {
            throw new ServerException( 'Could not read PID file, is the server running?' );
        }
        
        return $pid;
    }
    
    private function exec( $command )
    {
        $exitCode = 0;
        $output = exec( $command, $lines, $exitCode );
        
        if( $exitCode > 0 )
        {
            throw new ServerException( $output, $exitCode );
        }
        
        return $output;
    }
}